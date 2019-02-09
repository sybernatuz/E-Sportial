<?php

namespace App\Controller\Front;

use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SponsorController
 * @package App\Controller
 * @Route(path="/sponsor", name="app_sponsor_")
 */
class SponsorController extends AbstractController
{
    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        return $this->render('pages/front/sponsor/index.html.twig', [
            'controller_name' => 'SponsorController',
        ] + $this->footerService->process());
    }
}
