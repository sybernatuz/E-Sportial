<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 19:10
 */

namespace App\Controller;


use App\Objects\DataHolder;
use App\Services\home\LastRecruitmentsService;
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
    private $lastRecruitmentsService;

    private $tempDataHolder;
    private $finalDataHolder;

    public function __construct(LastResultsService $lastResultsService, LastRecruitmentsService $lastRecruitmentsService)
    {
        $this->tempDataHolder = new DataHolder();
        $this->finalDataHolder = new DataHolder();
        $this->lastResultsService = $lastResultsService;
        $this->lastRecruitmentsService = $lastRecruitmentsService;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        $this->lastResultsService->process($this->finalDataHolder);
        $this->lastRecruitmentsService->process($this->finalDataHolder);
        return $this->render("pages/home.html.twig", $this->finalDataHolder->getData());
    }

}