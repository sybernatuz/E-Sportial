<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminStatisticController
 * @package App\Controller\Admin
 * @Route(path="/admin", name="app_admin_statistic_")
 */
class AdminStatisticController extends AbstractController
{
    /**
     * @Route(path="/statistic", name="index")
     */
    public function index()
    {
        return $this->render('pages/back/home.html.twig', [
            'controller_name' => 'AdminStatisticController',
        ]);
    }
}
