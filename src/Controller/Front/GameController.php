<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 21/01/2019
 * Time: 13:51
 */

namespace App\Controller\Front;

use App\Entity\Game;
use App\Entity\Search\GameSearch;
use App\Form\Search\GameSearchType;
use App\Repository\EventRepository;
use App\Repository\GameRepository;
use App\Services\layout\FooterService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller
 * @Route(name="app_game_")
 */
class GameController extends AbstractController
{

    private const GAMES_NUMBER = 12;

    private $gameRepository;
    private $eventRepository;
    private $footerService;

    public function __construct(GameRepository $gameRepository, FooterService $footerService, EventRepository $eventRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->eventRepository = $eventRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="show", path="/game/{slug}")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Game $game) : Response
    {
        return $this->render('pages/front/game/show.html.twig', [
            'game' => $game,
            'events' => $this->eventRepository->findByLastDateAndGame($game)
        ] + $this->footerService->process());
    }

    /**
     * @Route(name="list", path="/games")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new GameSearch();
        $form = $this->createForm(GameSearchType::class, $search);
        $form->handleRequest($request);

        $games = $paginator->paginate(
            $this->gameRepository->findBySearch($search),
            $request->query->getInt('page', 1),
            self::GAMES_NUMBER
        );

        return $this->render('pages/front/game/list.html.twig', [
                'games' => $games,
                'searchForm' => $form->createView()
            ] + $this->footerService->process());
    }
}