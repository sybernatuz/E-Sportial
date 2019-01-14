<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 06/01/2019
 * Time: 16:29
 */

namespace App\Controller;


use App\Objects\DataHolder;
use App\Services\common\FooterService;
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

    private $finalDataHolder;

    public function __construct(FooterService $footerService)
    {
        $this->finalDataHolder = new DataHolder();
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        $this->footerService->process($this->finalDataHolder);
        return $this->render("pages/players.html.twig", $this->finalDataHolder->getData());
    }


}