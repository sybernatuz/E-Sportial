<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 15/01/2019
 * Time: 10:27
 */

namespace App\Controller\ajax;

use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JobAjaxController
 * @package App\Controller\ajax
 * @Route(name="app_job_ajax_", path="/ajax/job")
 */
class JobAjaxController extends AbstractController
{

    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @Route(name="get_detail", path="/get/detail/{id}")
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJob(Job $job) : Response
    {
//        return new JsonResponse($this->serializer->normalize($job, 'json', ['groups' => ['one']]));
        return $this->render("modules/front/jobs/jobDetail.html.twig", [
            'jobDetail' => $job
        ]);
    }

    /**
     * @Route(name="get_last_jobs", path="/get/last/jobs/{jobType}")
     * @param string $jobType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLastJobs(string $jobType) : Response
    {
        return $this->render("modules/front/jobs/lastJobs.html.twig", [
            'lastJobs' => $this->jobRepository->findByLastDateAndType(5, $jobType),
            'pageNumber' => $this->jobRepository->getPaginationByLastDateAndType(5, $jobType)
        ]);
    }

    /**
     * @Route(name="search", path="/search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request) : Response
    {
        $title = $request->get("title") != null ? $request->get("title") : '';
        $location = $request->get("location") != null ? $request->get("location") : '';
        $type = $request->get("type") != null ? $request->get("type") : '';
        $page = $request->get("page") != null ? $request->get("page") : 1;
        return $this->render("modules/front/jobs/lastJobs.html.twig", [
            'lastJobs' => $this->jobRepository->findByTitleAndLocationAndTypeOrderByLastDate($title, $location, $type, 5, $page),
            'pageNumber' => $this->jobRepository->getPaginationByTitleAndLocationAndType($title, $location, $type, 5),
            'activePage' => $page
        ]);
    }
}