<?php

namespace App\Controller\Front;

use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SponsorController
 * @package App\Controller
 * @Route(name="app_sponsor_")
 */
class SponsorController extends AbstractController
{
    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * @Route(path="/sponsors", name="list")
     */
    public function list()
    {
        return $this->render('pages/front/sponsor/list.html.twig', [
            'controller_name' => 'SponsorController',
        ] + $this->footerService->process());
    }
}
