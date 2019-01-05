<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 20:33
 */

namespace App\Services\home;


use App\Enums\type\JobTypeEnum;
use App\Objects\DataHolder;
use App\Repository\JobRepository;

class LastCoachingsService
{
    private const LAST_COACHINGS_NUMBER = 4;

    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function process(DataHolder $finalDataHolder)
    {
        $lastCoachings = $this->jobRepository->findByLastDateAndType(self::LAST_COACHINGS_NUMBER, JobTypeEnum::COACHING);
        $finalDataHolder->put("lastCoachings", $lastCoachings);
    }
}