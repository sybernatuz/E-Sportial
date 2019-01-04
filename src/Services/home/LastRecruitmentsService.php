<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/01/2019
 * Time: 23:11
 */

namespace App\Services\home;


use App\Objects\DataHolder;
use App\Repository\RecruitmentRepository;

class LastRecruitmentsService
{
    private const LAST_RECUITMENTS_NUMBER = 4;

    private $recruitmentRepository;

    public function __construct(RecruitmentRepository $recruitmentRepository)
    {
        $this->recruitmentRepository = $recruitmentRepository;
    }

    public function process(DataHolder $finalDataHolder)
    {
        $lastRecruitments = $this->recruitmentRepository->findByLastDate(self::LAST_RECUITMENTS_NUMBER);
        $finalDataHolder->put("lastRecruitments", $lastRecruitments);
    }
}