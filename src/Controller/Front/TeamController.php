<?php

namespace App\Controller\Front;

use App\Entity\Organization;
use App\Entity\Search\MemberSearch;
use App\Form\Search\MemberSearchType;
use App\Repository\OrganizationRepository;
use App\Repository\SubscriptionRepository;
use App\Services\layout\FooterService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 * @package App\Controller
 * @Route(name="app_team_")
 */
class TeamController extends AbstractController
{
    private const TEAMS_NUMBER = 12;

    private $footerService;
    private $teamRepository;

    public function __construct(FooterService $footerService, OrganizationRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(path="/teams", name="list")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request)
    {
        $search = new MemberSearch();
        $form = $this->createForm(MemberSearchType::class, $search);

        $form->handleRequest($request);

        $teams = $paginator->paginate(
            $this->teamRepository->findTeamBySearch($search),
            $request->query->getInt('page', 1),
            self::TEAMS_NUMBER
        );

        return $this->render('pages/front/team/list.html.twig', [
                'teams' => $teams,
                'form'  => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(path="/team/{slug}", name="show")
     * @param Organization $team
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Organization $team, SubscriptionRepository $subscriptionRepository) {
        $followers = $subscriptionRepository->getListOfSubscriber($team);
        return $this->render('pages/front/team/show.html.twig', [
                'team' => $team,
                'followers' => $followers
            ] + $this->footerService->process());
    }
}
