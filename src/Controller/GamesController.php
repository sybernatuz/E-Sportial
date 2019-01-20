<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 20/01/2019
 * Time: 00:39
 */

namespace App\Controller;


use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GamesController
 * @package App\Controller
 * @Route(name="app_games_", path="/games")
 */
class GamesController extends AbstractController
{
    private const GAMES_NUMBER = 12;
    private const FOOTER_GAMES_NUMBER = 5;

    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        return $this->render('pages/games.html.twig', [
            'gamesList' => $this->gameRepository->findByOrderByNameAsc(self::GAMES_NUMBER),
            'pageNumber' => $this->gameRepository->getPagination(self::GAMES_NUMBER),
            'footerGames' => $this->gameRepository->findByMostPopular(self::FOOTER_GAMES_NUMBER)
        ]);
    }
}