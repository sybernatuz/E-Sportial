<?php

namespace App\Controller\Ajax;

use App\Entity\GameAccount;
use App\Entity\User;
use App\Form\Front\User\AddGameFormType;
use App\Handler\Member\SubscriptionHandler;
use App\Repository\GameAccountRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param GameAccountRepository $gameAccountRepository
     * @return JsonResponse
     */
    public function gameTab(User $user, Request $request, GameAccountRepository $gameAccountRepository) {
        if(!$user) {
            throw $this->createNotFoundException('The user not exist');
        }

        $gameAccount = new GameAccount();
        $gameAccount->setGamer($user);

        $addGameForm = $this->createForm(AddGameFormType::class, $gameAccount);
        $addGameForm->handleRequest($request);

        if($addGameForm->isSubmitted()) {
            $this->em->persist($gameAccount);
            $this->em->flush();

            $html = $this->renderView('modules/front/game/list/games_list.html.twig', [
                "games" => $gameAccountRepository->findUserGames($user)
            ]);
            return new JsonResponse($html);
        }

        $html = $this->renderView('modules/front/user/show/tab/game/game_tab.html.twig', [
            "form" => $addGameForm->createView(),
            "user" => $user,
            "games" => $gameAccountRepository->findUserGames($user)
        ]);

        return new JsonResponse($html);
    }
}
