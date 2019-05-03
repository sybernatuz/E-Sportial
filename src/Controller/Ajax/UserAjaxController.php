<?php

namespace App\Controller\Ajax;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\User;
use App\Form\Front\User\AddGameFormType;
use App\Form\Front\User\SelectGameUserType;
use App\Handler\Member\SubscriptionHandler;
use App\Repository\GameRepository;
use App\Services\Game\GameStatService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route(path="/{id}/subscribe", name="subscribe")
     * @param User $member
     * @return JsonResponse
     */
    public function subscribe(User $member) {
        $data = $this->subscriptionHandler->subscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }

    /**
     * @Route(path="/{id}/unsubscribe", name="unsubscribe")
     * @param User $member
     * @return JsonResponse
     */
    public function unsubscribe(User $member) {
        $data = $this->subscriptionHandler->unsubscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }

    /**
     * @Route(path="/{id}/game_tab", name="game_tab", options={"expose"=true}, methods={"POST", "GET"})
     * @param User $user
     * @param Request $request
     * @param GameRepository $gameRepository
     * @return JsonResponse
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
            $html = $this->renderView('modules/front/game/list/games_list.html.twig', [
                "games" => $gameRepository->findUserGames($user)
            ]);
            return new JsonResponse($html);
        }

        $html = $this->renderView('modules/front/user/show/tab/game/game_tab.html.twig', [
            "form" => $addGameForm->createView(),
            "user" => $user,
            "games" => $gameRepository->findUserGames($user)
        ]);

        return new JsonResponse($html);
    }

    /**
     * @Route(path="/{id}/stat_tab", name="stat_tab", options={"expose"=true}, methods={"POST", "GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function statTab(User $user) {
        if(!$user) {
            throw $this->createNotFoundException('The user not exist');
        }

        $selectGameForm = $this->createForm(SelectGameUserType::class, null, [
            'user' => $user
        ]);

        $html = $this->renderView('modules/front/user/show/tab/stat/stat_tab.html.twig', [
            "form" => $selectGameForm->createView()
        ]);

        return new JsonResponse($html);
    }

    /**
     * @Route(path="/{userId}/game_stats/{gameId}", name="game_stats", options={"expose"=true})
     * @ParamConverter("user", options={"id" = "userId"})
     * @ParamConverter("game", options={"id" = "gameId"})
     * @param User $user
     * @param Game $game
     * @param GameStatService $gameStatService
     * @return JsonResponse
     */
    public function renderGameStats(User $user, Game $game, GameStatService $gameStatService) {
        if(!$user || !$game) {
            throw $this->createNotFoundException('The user or game not exist');
        }

        try {
            $data = $gameStatService->getGameStats($game, $user);
            $template = $gameStatService->getGameStatsTemplate($game->getSlug());
        } catch (\RuntimeException $e) {
            $data = $e->getMessage();
            $template = $gameStatService->getGameStatsTemplate($game->getSlug(), true);
        }


        $html = $this->renderView($template, [
            "data" => $data
        ]);

        return new JsonResponse($html);
    }
}
