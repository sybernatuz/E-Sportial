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
    private const JOBS_NUMBER = 5;
    private const FOOTER_GAMES_NUMBER = 5;

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
        $lastJobs = $this->jobRepository->findByLastDateAndType(self::JOBS_NUMBER, JobTypeEnum::WORK);
        return $this->render("pages/jobs.html.twig", [
            'lastJobs' => $lastJobs,
            'jobDetail' => $lastJobs[0] ?? null,
            'pageNumber' => $this->jobRepository->getPaginationByLastDateAndType(self::JOBS_NUMBER, JobTypeEnum::WORK),
            'footerGames' => $this->gameRepository->findByMostPopular(self::FOOTER_GAMES_NUMBER)
        ]);
    }
}