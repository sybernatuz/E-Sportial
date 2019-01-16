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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JobAjaxController
 * @package App\Controller\ajax
 * @Route(name="app_job_ajax_", path="/ajax/job")
 */
class JobAjaxController extends AbstractController
{

    private $jobRepository;
    private $serializer;

    public function __construct(JobRepository $jobRepository, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->jobRepository = $jobRepository;
    }

    /**
     *
     * @Route(name="get_detail", path="/get/detail/{id}")
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJob(Job $job)
    {
//        return new JsonResponse($this->serializer->normalize($job, 'json', ['groups' => ['one']]));
        return $this->render("modules/jobs/jobDetail.html.twig", [
            'jobDetail' => $job
        ]);
    }
}