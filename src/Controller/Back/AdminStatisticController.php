<?php

namespace App\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminStatisticController
 * @package App\Controller\Admin
 * @Route(path="/admin", name="app_admin_statistic_")
 */
class AdminStatisticController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(path="/statistic", name="index")
     */
    public function index()
    {
        return $this->render('pages/back/home.html.twig', [
            'registeredUsers' => $this->userRepository->count([])
        ]);
    }
}
