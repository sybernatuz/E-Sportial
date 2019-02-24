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
use App\Repository\JobRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Mapper
{
    private $token;
    private $jobRepository;

    public function __construct(TokenStorageInterface $token, JobRepository $jobRepository)
    {
        $this->token = $token;
        $this->jobRepository = $jobRepository;
    }

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


        $jobDetail->setIsApplied($this->isJobApplied($job));

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

    private function isJobApplied(Job $job) : bool
    {
        $user = $this->token->getToken()->getUser();
        $applicant = $this->jobRepository->findByUserApplied($job->getId(), $user);
        return $applicant == null ? false : true;
    }
}