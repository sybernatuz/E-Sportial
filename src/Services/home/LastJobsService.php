<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 00:16
 */

namespace App\Services\home;


use App\Enums\type\JobTypeEnum;
use App\Objects\DataHolder;
use App\Repository\JobRepository;

class LastJobsService
{
    private const LAST_JOBS_NUMBER = 4;

    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function process(DataHolder $finalDataHolder)
    {
        $lastJobs = $this->jobRepository->findByLastDateAndType(self::LAST_JOBS_NUMBER, JobTypeEnum::WORK);
        $finalDataHolder->put("lastJobs", $lastJobs);
    }
}