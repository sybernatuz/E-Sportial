<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 14/01/2019
 * Time: 17:41
 */

namespace App\Controller\Front;


use App\Entity\Job;
use App\Entity\Search\JobSearch;
use App\Entity\User;
use App\Form\Front\Job\EditFormType;
use App\Form\Front\Job\NewFormType;
use App\Form\Search\JobSearchType;
use App\Repository\JobRepository;
use App\Services\layout\FooterService;
use App\Voter\JobVoter;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new JobSearch();
        $searchForm = $this->createForm(JobSearchType::class, $search);
        $searchForm->handleRequest($request);

        $jobs = $paginator->paginate(
            $this->jobRepository->findBySearchOrderByLastDate($search),
            $request->query->getInt('page', 1),
            self::JOBS_NUMBER
        );

        return $this->render("pages/front/job/list.html.twig", [
            'lastJobs' => $jobs,
            'searchForm' => $searchForm->createView()
        ] + $this->footerService->process());
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="manage", path="/jobs/manage")
     * @return Response
     */
    public function manage() : Response
    {
        $jobs = $this->jobRepository->findByCreator($this->getUser());
        return $this->render('pages/front/job/manage.html.twig', [
           'jobs' => $jobs
        ] + $this->footerService->process());
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="show", path="/job/{id}/show")
     * @param Job $job
     * @return Response
     */
    public function show(Job $job) : Response
    {
        $this->denyAccessUnlessGranted(JobVoter::EDIT, $job);
        return $this->render('pages/front/job/show.html.twig', [
                'job' => $job
            ] + $this->footerService->process());
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="edit", path="/job/{id}/edit")
     * @param Job $job
     * @param Request $request
     * @return Response
     */
    public function edit(Job $job, Request $request) : Response
    {
        $this->denyAccessUnlessGranted(JobVoter::EDIT, $job);
        $form = $this->createForm(EditFormType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Job edited successfully');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred');
            }
        }
        return $this->render('pages/front/job/edit.html.twig', [
           'job' => $job,
           'editForm' => $form->createView()
        ] + $this->footerService->process());
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="new", path="/job/new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $job = new Job();
        $form = $this->createForm(NewFormType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($job);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('pages/front/job/new.html.twig', [
                'newForm' => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(name="delete", path="/job/{id}/delete")
     * @param Job $job
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Job $job)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($job);
        $manager->flush();

        $this->addFlash("success", "Job delete successfully");
        return $this->redirectToRoute('app_job_manage');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(name="delete_user", path="/job/{jobId}/delete/{userId}")
     * @param int $jobId
     * @param int $userId
     * @return Response
     */
    public function deleteUser(int $jobId, int $userId) : Response
    {
        $job = $this->jobRepository->find($jobId);
        $this->denyAccessUnlessGranted(JobVoter::EDIT, $job);
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->find(User::class, $userId);
        $job->removeApplicant($user);
        $manager->flush();
        return $this->redirectToRoute('app_job_show', ['id' => $jobId]);
    }
}