<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 21/01/2019
 * Time: 13:51
 */

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller
 * @Route(name="app_game_", path="/game")
 */
class GameController
{

    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route(name="index", path="/{slug}")
     */
    public function index()
    {

    }
}