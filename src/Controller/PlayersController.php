<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 06/01/2019
 * Time: 16:29
 */

namespace App\Controller;


use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlayersController
 * @package App\Controller
 * @Route(name="app_players_", path="/players")
 */
class PlayersController extends AbstractController
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
        return $this->render("pages/players.html.twig", $this->footerService->process());
    }


}