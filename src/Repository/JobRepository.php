<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
     * @param int $jobsNumber
     * @param string $type
     * @return Job[] Returns an array of Recruitment objects
     */
    public function findByLastDateAndType(int $jobsNumber, string $type)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type)
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults($jobsNumber)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Job
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
