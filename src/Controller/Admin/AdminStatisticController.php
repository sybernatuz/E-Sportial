<?php

namespace App\Controller\Admin;

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
        return $this->render('admin_statistic/index.html.twig', [
            'controller_name' => 'AdminStatisticController',
        ]);
    }
}
