<?php

namespace App\Controller\Front;

use App\Entity\Organization;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 * @package App\Controller
 * @Route(path="/team", name="app_team_")
 */
class TeamController extends AbstractController
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
        return $this->render('pages/front/team/index.html.twig', $this->footerService->process());
    }

    /**
     * @Route(path="/{slug}", name="show")
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Organization $team) {
        return $this->render('pages/front/team/show.html.twig', [
                'team' => $team,
            ] + $this->footerService->process());
    }
}
