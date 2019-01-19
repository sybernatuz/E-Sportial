<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function findByTitleAndLocationAndTypeOrderByLastDate(string $title, string $location, string $type, int $jobNumber, int $page = 1)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->andwhere('LOWER(j.title) LIKE LOWER(:title)')
            ->andWhere('LOWER(j.location) LIKE LOWER(:location)')
            ->setParameter(':type', $type)
            ->setParameter(':title', '%'.$title.'%')
            ->setParameter(':location', '%'.$location.'%')
            ->orderBy('j.createdAt', 'DESC')
            ->setFirstResult($jobNumber * $page - $jobNumber)
            ->setMaxResults($jobNumber)
            ->getQuery()
            ->getResult();
    }

    public function getPaginationByTitleAndLocationAndType(string $title, string $location, string $type, int $jobNumber)
    {
        try {
            return $this->createQueryBuilder('j')
                ->select('COUNT(j.id) / ' . $jobNumber)
                ->leftJoin('j.type', 't')
                ->where('t.name = :type')
                ->andwhere('LOWER(j.title) LIKE LOWER(:title)')
                ->andWhere('LOWER(j.location) LIKE LOWER(:location)')
                ->setParameter(':type', $type)
                ->setParameter(':title', '%' . $title . '%')
                ->setParameter(':location', '%' . $location . '%')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findByLastDateAndType(int $jobsNumber, string $type)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type)
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults($jobsNumber)
            ->getQuery()
            ->getResult();
    }

    public function getPaginationByLastDateAndType(int $jobsNumber, string $type)
    {
        try {
            return $this->createQueryBuilder('j')
                ->select('COUNT(j.id) / ' . $jobsNumber)
                ->leftJoin('j.type', 't')
                ->where('t.name = :type')
                ->setParameter(':type', $type)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
