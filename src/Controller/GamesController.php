<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 20/01/2019
 * Time: 00:39
 */

namespace App\Controller;


use App\Repository\GameRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GamesController
 * @package App\Controller
 * @Route(name="app_games_", path="/games")
 */
class GamesController extends AbstractController
{
    private const GAMES_NUMBER = 12;

    private $gameRepository;
    private $footerService;

    public function __construct(GameRepository $gameRepository, FooterService $footerService)
    {
        $this->gameRepository = $gameRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() : Response
    {
        return $this->render('pages/games.html.twig', [
            'gamesList' => $this->gameRepository->findByOrderByNameAsc(self::GAMES_NUMBER),
            'pageNumber' => $this->gameRepository->getPagination(self::GAMES_NUMBER)
        ] + $this->footerService->process());
    }
}