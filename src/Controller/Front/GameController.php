<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 21/01/2019
 * Time: 13:51
 */

namespace App\Controller\Front;

use App\Entity\Game;
use App\Repository\EventRepository;
use App\Repository\GameRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route(name="one", path="/game/{slug}")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Game $game) : Response
    {
        return $this->render('pages/front/game/game.html.twig', [
            'game' => $game,
            'events' => $this->eventRepository->findByLastDateAndGame($game)
        ] + $this->footerService->process());
    }

    /**
     * @Route(name="list", path="/games")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list() : Response
    {
        return $this->render('pages/front/game/games.html.twig', [
                'gamesList' => $this->gameRepository->findByOrderByNameAsc(self::GAMES_NUMBER),
                'pageNumber' => $this->gameRepository->getPagination(self::GAMES_NUMBER)
            ] + $this->footerService->process());
    }
}