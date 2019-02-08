<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 20/01/2019
 * Time: 01:13
 */

namespace App\Controller\ajax;


use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameAjaxController
 * @package App\Controller\ajax
 * @Route(name="app_game_ajax_", path="/ajax/game")
 */
class GameAjaxController extends AbstractController
{

    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route(name="search", path="/search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request) : Response
    {
        $name = $request->get("name") != null ? $request->get("name") : '';
        $page = $request->get("page") != null ? $request->get("page") : 1;
        return $this->render("modules/front//games/gamesList.html.twig", [
            'gamesList' => $this->gameRepository->findByName($name, 12, $page),
            'pageNumber' => $this->gameRepository->getPaginationByName($name, 12),
            'activePage' => $page
        ]);
    }
}