<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 14/01/2019
 * Time: 17:41
 */

namespace App\Controller\Front;


use App\Entity\Search\JobSearch;
use App\Form\Search\JobSearchType;
use App\Repository\JobRepository;
use App\Services\layout\FooterService;
use Knp\Component\Pager\PaginatorInterface;
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
}