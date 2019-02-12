<?php

namespace App\Controller\Front;

use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdvertiserController
 * @package App\Controller
 * @Route(path="/advertiser", name="app_advertiser_")
 */
class AdvertiserController extends AbstractController
{
    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="list")
     */
    public function list()
    {
        return $this->render('pages/front/advertiser/list.html.twig', [
            'controller_name' => 'AdvertiserController',
        ] + $this->footerService->process());
    }
}
