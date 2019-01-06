<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 19:10
 */

namespace App\Controller;


use App\Objects\DataHolder;
use App\Services\common\FooterService;
use App\Services\home\LastCoachingsService;
use App\Services\home\LastJobsService;
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
    private $lastJobsService;
    private $lastCoachingsService;
    private $footerService;

    private $finalDataHolder;

    public function __construct(LastResultsService $lastResultsService, LastRecruitmentsService $lastRecruitmentsService, LastJobsService $lastJobsService, LastCoachingsService $lastCoachingsService, FooterService $footerService)
    {
        $this->finalDataHolder = new DataHolder();
        $this->lastResultsService = $lastResultsService;
        $this->lastRecruitmentsService = $lastRecruitmentsService;
        $this->lastJobsService = $lastJobsService;
        $this->lastCoachingsService = $lastCoachingsService;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        $this->lastResultsService->process($this->finalDataHolder);
        $this->lastRecruitmentsService->process($this->finalDataHolder);
        $this->lastJobsService->process($this->finalDataHolder);
        $this->lastCoachingsService->process($this->finalDataHolder);
        $this->footerService->process($this->finalDataHolder);
        return $this->render("pages/home.html.twig", $this->finalDataHolder->getData());
    }

}