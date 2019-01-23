<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 19:10
 */

namespace App\Controller;


use App\Enums\type\EventTypeEnum;
use App\Enums\type\JobTypeEnum;
use App\Repository\EventRepository;
use App\Repository\JobRepository;
use App\Repository\RecruitmentRepository;
use App\Services\layout\FooterService;
use App\Services\home\LastResultsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route(name="app_home_", path="/")
 */
class HomeController extends AbstractController
{
    private const LAST_EVENTS_NUMBER = 3;
    private const LAST_RECUITMENTS_NUMBER = 4;
    private const LAST_JOBS_NUMBER = 4;
    private const LAST_COACHINGS_NUMBER = 4;

    private $eventRepository;
    private $recruitmentRepository;
    private $jobRepository;
    private $lastResultsService;
    private $footerService;

    public function __construct(EventRepository $eventRepository, RecruitmentRepository $recruitmentRepository, JobRepository $jobRepository, FooterService $footerService, LastResultsService $lastResultsService)
    {
        $this->eventRepository = $eventRepository;
        $this->recruitmentRepository = $recruitmentRepository;
        $this->jobRepository = $jobRepository;
        $this->lastResultsService = $lastResultsService;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() : Response
    {
        return $this->render("pages/home.html.twig", [
            'lastEvents' => $this->eventRepository->findByLastDateAndType(self::LAST_EVENTS_NUMBER, EventTypeEnum::ALL),
            'lastRecruitments' => $this->recruitmentRepository->findByLastDate(self::LAST_RECUITMENTS_NUMBER),
            'lastJobs' => $this->jobRepository->findByLastDateAndType(self::LAST_JOBS_NUMBER, JobTypeEnum::WORK),
            'lastCoachings' => $this->jobRepository->findByLastDateAndType(self::LAST_COACHINGS_NUMBER, JobTypeEnum::COACHING)
        ] + $this->footerService->process()
          + $this->lastResultsService->process());
    }

}