<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 14/01/2019
 * Time: 17:41
 */

namespace App\Controller\Front;


use App\Enums\type\JobTypeEnum;
use App\Repository\JobRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JobsController
 * @package App\Controller
 * @Route(name="app_job_")
 */
class JobController extends AbstractController
{
    private const JOBS_NUMBER = 5;

    private $jobRepository;
    private $footerService;

    public function __construct(JobRepository $jobRepository, FooterService $footerService)
    {
        $this->jobRepository = $jobRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="list", path="/jobs")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list() : Response
    {
        $lastJobs = $this->jobRepository->findByLastDateAndType(self::JOBS_NUMBER, JobTypeEnum::WORK);
        return $this->render("pages/front/jobs.html.twig", [
            'lastJobs' => $lastJobs,
            'jobDetail' => $lastJobs[0] ?? null,
            'pageNumber' => $this->jobRepository->getPaginationByLastDateAndType(self::JOBS_NUMBER, JobTypeEnum::WORK)
        ] + $this->footerService->process());
    }
}