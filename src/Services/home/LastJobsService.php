<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 00:16
 */

namespace App\Services\home;


use App\Objects\DataHolder;
use App\Repository\JobRepository;

class LastJobsService
{
    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function process(DataHolder $finalDataHolder)
    {
        $lastJobs = $this->jobRepository->findByLastDate(4);
        $finalDataHolder->put("lastJobs", $lastJobs);
    }
}