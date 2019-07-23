<?php

namespace App\Controller\Ajax;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\Notification;
use App\Entity\User;
use App\Exceptions\GameAccount\GameAccountNotFoundException;
use App\Form\Front\User\AddGameFormType;
use App\Form\Front\User\SelectGameUserType;
use App\Handler\Member\SubscriptionHandler;
use App\Repository\GameAccountRepository;
use App\Repository\GameRepository;
use App\Services\Game\GameStats\GameStatsFactory;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_user_ajax_", path="/ajax/user")
 */
class UserAjaxController extends AbstractController
{
    private $serializer;
    private $subscriptionHandler;
    private $em;

    public function __construct(SerializerInterface $serializer, SubscriptionHandler $subscriptionHandler, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->subscriptionHandler = $subscriptionHandler;
        $this->em = $em;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/subscribe", name="subscribe", options={"expose"=true})
     * @param User $member
     * @return JsonResponse
     */
    public function subscribe(User $member) {
        $data = $this->subscriptionHandler->subscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/unsubscribe", name="unsubscribe", options={"expose"=true})
     * @param User $member
     * @return JsonResponse
     */
    public function unsubscribe(User $member) {
        $data = $this->subscriptionHandler->unsubscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/recruit", name="recruit", options={"expose"=true})
     * @param User $member
     * @param Security $security
     * @return JsonResponse
     * @throws \Exception
     */
    public function recruit(User $member, Security $security) {
        $notification = new Notification();
        $notification->setType('recruitment');
        $notification->setUser($member);
        $notification->setStatus(false);
        $notification->setAuthor($security->getUser());
        $this->em->persist($notification);
        $this->em->flush();
        return new JsonResponse(true);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/recruitment", name="recruitment_state", options={"expose"=true})
     * @param User $member
     * @param Security $security
     * @return JsonResponse
     */
    public function getRecruitmentState(User $member, Security $security) {
        $notification = $this->em->getRepository(Notification::class)->findOneBy(['author' => $security->getUser(), 'user' => $member, 'type'=>'recruitment']);
        $result = false;
        if($notification) {
          $result = true;
        }
        return new JsonResponse($result);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/recruit/cancel", name="recruit_cancel", options={"expose"=true})
     * @param User $member
     * @param Security $security
     * @return JsonResponse
     */
    public function cancelRecruit(User $member, Security $security) {
        $notification = $this->em->getRepository(Notification::class)->findOneBy(['author' => $security->getUser(), 'user' => $member, 'type'=>'recruitment']);
        $this->em->remove($notification);
        $this->em->flush();
        return new JsonResponse(false);
    }

    /**
     * @Route(path="/{id}/game_tab", name="game_tab", options={"expose"=true}, methods={"POST", "GET"})
     * @param User $user
     * @param Request $request
     * @param GameRepository $gameRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gameTab(User $user, Request $request, GameRepository $gameRepository) {
        if(!$user) {
            throw $this->createNotFoundException('The user not exist');
        }

        $gameAccount = new GameAccount();
        $gameAccount->setGamer($user);

        $addGameForm = $this->createForm(AddGameFormType::class, $gameAccount);
        $addGameForm->handleRequest($request);

        if($addGameForm->isSubmitted() && $addGameForm->isValid()) {
            $this->em->persist($gameAccount);
            $this->em->flush();
            return $this->render('modules/front/game/list/games_list.html.twig', [
                "games" => $gameRepository->findUserGames($user)
            ]);
        }

        return $this->render('modules/front/user/show/tab/game/game_tab.html.twig', [
            "form" => $addGameForm->createView(),
            "user" => $user,
            "games" => $gameRepository->findUserGames($user)
        ]);

    }

    /**
     * @Route(path="/{id}/stat_tab", name="stat_tab", options={"expose"=true}, methods={"POST", "GET"})
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statTab(User $user) {
        if(!$user) {
            throw $this->createNotFoundException('The user not exist');
        }

        $selectGameForm = $this->createForm(SelectGameUserType::class, null, [
            'user' => $user
        ]);

        return $this->render('modules/front/user/show/tab/stat/stat_tab.html.twig', [
            "form" => $selectGameForm->createView()
        ]);
    }

    /**
     * @Route(path="/{userId}/game_stats/{gameId}", name="game_stats", options={"expose"=true})
     * @ParamConverter("user", options={"id" = "userId"})
     * @ParamConverter("game", options={"id" = "gameId"})
     * @param User $user
     * @param Game $game
     * @param GameStatsFactory $gameStatsFactory
     * @param GameAccountRepository $gameAccountRepository
     * @return string
     */
    public function renderGameStats(User $user, Game $game, GameStatsFactory $gameStatsFactory, GameAccountRepository $gameAccountRepository) {
        if(!$user || !$game) {
            throw $this->createNotFoundException('The user or game not exist');
        }

        $gameAccount = $gameAccountRepository->findByUserAndGame($user, $game);
        if(!$gameAccount) {
            throw new GameAccountNotFoundException($game);
        }

        $gameStatService = $gameStatsFactory->create($game);
        $data = $gameStatService->getUserStats($game->getApiUrl(), $gameAccount->getPseudo());
        $template = $gameStatService->getStatsTemplate();
        return $this->render($template, [
            "data" => $data
        ]);
    }
}
