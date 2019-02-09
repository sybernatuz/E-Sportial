<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\layout\FooterService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route(path="/user", name="app_user_")
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
     * @Route(name="index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $users = $paginator->paginate(
            $this->userRepository->findAllOrderedBySubscriptionsQuery(),
            $request->query->getInt('page', 1),
            self::USERS_NUMBER
        );

        return $this->render('pages/front/user/index.html.twig', [
            'users' => $users,
        ] + $this->footerService->process());
    }

    /**
     * @Route("/{slug}", name="show")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(User $user)
    {
        return $this->render('pages/front/user/show.html.twig', [
            'user' => $user
        ] + $this->footerService->process());
    }
}
