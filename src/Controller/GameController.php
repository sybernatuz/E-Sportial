<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 21/01/2019
 * Time: 13:51
 */

namespace App\Controller;

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
 * @Route(name="app_game_", path="/game")
 */
class GameController extends AbstractController
{

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
     * @Route(name="index", path="/{slug}")
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Game $game) : Response
    {
        return $this->render('pages/game.html.twig', [
            'game' => $game,
            'events' => $this->eventRepository->findByLastDateAndGame($game)
        ] + $this->footerService->process());
    }
}