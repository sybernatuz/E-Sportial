<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 14/01/2019
 * Time: 17:41
 */

namespace App\Controller;


use App\Enums\type\JobTypeEnum;
use App\Repository\GameRepository;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class JobsController
 * @package App\Controller
 * @Route(name="app_jobs_", path="/jobs")
 */
class JobsController extends AbstractController
{
    private $jobRepository;
    private $gameRepository;

    public function __construct(JobRepository $jobRepository, GameRepository $gameRepository)
    {
        $this->jobRepository = $jobRepository;
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        $lastJobs = $this->jobRepository->findByLastDateAndType(5, JobTypeEnum::WORK);
        return $this->render("pages/jobs.html.twig", [
            'footerGames' => $this->gameRepository->findByMostPopular(5),
            'lastJobs' => $lastJobs,
            'jobDetail' => $lastJobs[0] ?? null,
            'pageNumber' => $this->jobRepository->getPaginationByLastDateAndType(5, JobTypeEnum::WORK)
        ]);
    }
}