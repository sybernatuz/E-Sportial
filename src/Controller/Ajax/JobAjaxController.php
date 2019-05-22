<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 15/01/2019
 * Time: 10:27
 */

namespace App\Controller\Ajax;

use App\Entity\Job;
use App\Entity\User;
use App\Repository\JobRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
    private $token;

    public function __construct(SerializerInterface $serializer, JobRepository $jobRepository, TokenStorageInterface $token)
    {
        $this->jobRepository = $jobRepository;
        $this->serializer = $serializer;
        $this->token = $token;
    }

    /**
     * @Route(name="get_detail", path="/get/detail/{id}")
     * @param Job $job
     * @return Response
     */
    public function getJob(Job $job) : Response
    {
        if($this->isGranted('ROLE_USER')) {
            $user = $this->token->getToken()->getUser();
            if ($user instanceof User) {
                $applicant = $this->jobRepository->findByUserApplied($job->getId(), $user);
            }
            $isApplied = isset($applicant) && $applicant != null ? true : false;
        }
        return $this->render("modules/front/job/list/job_detail.html.twig", [
            'jobDetail' => $job,
            'isApplied' => $isApplied ?? false
        ]);
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
        if ($applicant = $this->jobRepository->findByUserApplied($job->getId(), $user))
            return new JsonResponse($this->serializer->normalize(false, 'json'));

        $job->addApplicant($user);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($this->serializer->normalize(true, 'json'));
    }
}