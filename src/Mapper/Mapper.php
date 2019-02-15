<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 17:05
 */

namespace App\Mapper;


use App\Entity\Job;
use App\Entity\Out\JobDetail\JobDetailOut;
use App\Entity\Out\JobDetail\OrganizationOut;
use App\Entity\Out\JobDetail\UserOut;

class Mapper
{

    public function jobEntityToJobDetailOut(Job $job) : ?JobDetailOut
    {
        if ($job == null)
            return null;

        $jobDetail = (new JobDetailOut())
            ->setId($job->getId())
            ->setDescription($job->getDescription())
            ->setTitle($job->getTitle())
            ->setLocation($job->getLocation())
            ->setCreatedAt($job->getCreatedAt())
            ->setDuration($job->getDuration())
            ->setSalary($job->getSalary());

        if ($user = $job->getUser()) {
            $userOut = (new UserOut())
                ->setId($user->getId())
                ->setUsername($user->getUsername())
                ->setAvatar($user->getAvatar());
            $jobDetail->setUser($userOut);
        }
        if ($organization = $job->getOrganization()) {
            $organizationOut = (new OrganizationOut())
                ->setId($organization->getId())
                ->setName($organization->getName())
                ->setLogoPath($organization->getLogoPath());
            $jobDetail->setOrganization($organizationOut);
        }
        return $jobDetail;
    }
}