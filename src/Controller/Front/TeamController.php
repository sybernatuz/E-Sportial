<?php

namespace App\Controller\Front;

use App\Entity\Organization;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 * @package App\Controller
 * @Route(name="app_team_")
 */
class TeamController extends AbstractController
{
    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * @Route(path="/teams", name="list")
     */
    public function list()
    {
        return $this->render('pages/front/team/list.html.twig', $this->footerService->process());
    }

    /**
     * @Route(path="/team/{slug}", name="show")
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Organization $team) {
        return $this->render('pages/front/team/show.html.twig', [
                'team' => $team,
            ] + $this->footerService->process());
    }
}
