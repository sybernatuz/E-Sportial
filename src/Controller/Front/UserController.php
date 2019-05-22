<?php

namespace App\Controller\Front;

use App\Entity\Search\MemberSearch;
use App\Entity\User;
use App\Form\Front\User\EditFormType;
use App\Form\Search\MemberSearchType;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use App\Services\layout\FooterService;
use App\Voter\UserVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route(name="app_user_")
 */
class UserController extends AbstractController
{
    private const USERS_NUMBER = 12;

    private $footerService;
    private $userRepository;

    public function __construct(FooterService $footerService, UserRepository $userRepository)
    {
        $this->footerService = $footerService;
        $this->userRepository = $userRepository;
    }


    /**
     * @Route(path="/users", name="list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request)
    {
        $search = new MemberSearch();
        $form = $this->createForm(MemberSearchType::class, $search);

        $form->handleRequest($request);

        $users = $paginator->paginate(
            $this->userRepository->findBySearch($search),
            $request->query->getInt('page', 1),
            self::USERS_NUMBER
        );

        return $this->render('pages/front/user/list.html.twig', [
            'users' => $users,
            'form'  => $form->createView()
        ] + $this->footerService->process());
    }

    /**
     * @Route(path="/user/{slug}", name="show")
     * @param User $user
     * @param SubscriptionRepository $subscriptionRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(User $user, SubscriptionRepository $subscriptionRepository)
    {
        $followers = $subscriptionRepository->getListOfSubscriber($user);
        return $this->render('pages/front/user/show.html.twig', [
            'user' => $user,
            'followers' => $followers,
        ] + $this->footerService->process());
    }

    /**
     * @Route(path="user/{slug}/edit", name="edit")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(User $user, Request $request)
    {
        $this->denyAccessUnlessGranted(UserVoter::EDIT, $user);
        $form = $this->createForm(EditFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Profile edited successfully');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred');
            }
        }

        return $this->render('pages/front/user/edit.html.twig', [
                'form' => $form->createView(),
                'user' => $user
            ] + $this->footerService->process());
    }
}
