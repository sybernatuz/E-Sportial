<?php

namespace App\Repository;

use App\Entity\Result;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Result|null find($id, $lockMode = null, $lockVersion = null)
 * @method Result|null findOneBy(array $criteria, array $orderBy = null)
 * @method Result[]    findAll()
 * @method Result[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Result::class);
    }

    public function findIdsByLastDateGroupByAndLimit($resultsNumber) : array
    {
        return $this->createQueryBuilder('result')
            ->select("IDENTITY(result.party) as partyId")
            ->groupBy("partyId")
            ->orderBy('result.date', 'DESC')
            ->setMaxResults($resultsNumber)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Result
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
