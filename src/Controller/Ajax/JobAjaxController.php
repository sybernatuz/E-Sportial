<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 15/01/2019
 * Time: 10:27
 */

namespace App\Controller\Ajax;

use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render("modules/front/job/list/job_detail.html.twig", [
            'jobDetail' => $job
        ]);
    }
}