<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 15/01/2019
 * Time: 10:27
 */

namespace App\Controller\Ajax;

use App\Entity\Job;
use App\Mapper\Mapper;
use App\Repository\JobRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    private $mapper;

    public function __construct(SerializerInterface $serializer, JobRepository $jobRepository, Mapper $mapper)
    {
        $this->jobRepository = $jobRepository;
        $this->serializer = $serializer;
        $this->mapper = $mapper;
    }

    /**
     * @Route(name="get_detail", path="/get/detail/{id}")
     * @param Job $job
     * @return JsonResponse
     */
    public function getJob(Job $job) : JsonResponse
    {
        $jobDetailOut = $this->mapper->jobEntityToJobDetailOut($job);
        return new JsonResponse($this->serializer->normalize($jobDetailOut, 'json'));
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="apply", path="/apply/{id}")
     * @param Job $job
     * @return JsonResponse
     */
    public function apply(Job $job) : JsonResponse
    {
        $user = $this->getUser();
        $job->addApplicant($user);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($this->serializer->normalize(true, 'json'));
    }
}