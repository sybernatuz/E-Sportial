<?php

namespace App\Repository;

use App\Entity\Job;
use App\Entity\Search\JobSearch;
use App\Enums\type\JobTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
     * Used for pagination
     * @param JobSearch $search
     * @return Query
     */
    public function findBySearchOrderByLastDate(JobSearch $search): Query
    {
        $query = $this->createQueryBuilder('j')
            ->orderBy('j.createdAt', 'DESC');

        if ($word = $search->getWord()) {
            $query->andWhere('j.title LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($location = $search->getLocation()) {
            $query->andWhere('j.location LIKE :location')
                ->setParameter('location', '%' . $location . '%');
        }

        $type = $search->getType() != null ? $search->getType()->getName() : JobTypeEnum::WORK;
        $query->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type);

        return $query->getQuery();
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
}
