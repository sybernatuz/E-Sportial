<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 19:10
 */

namespace App\Controller;


use App\Objects\DataHolder;
use App\Services\home\LastResultsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route(name="app_home_", path="/")
 */
class HomeController extends AbstractController
{
    private $lastResultsService;

    private $tempDataHolder;
    private $finalDataHolder;

    public function __construct(LastResultsService $lastResultsService)
    {
        $this->tempDataHolder = new DataHolder();
        $this->finalDataHolder = new DataHolder();
        $this->lastResultsService = $lastResultsService;
    }

    /**
     * @Route(name="handleRequest")
     */
    public function handleRequest()
    {
        $this->lastResultsService->process($this->finalDataHolder);
        return $this->render("pages/home.html.twig", $this->finalDataHolder->getData());
    }

}