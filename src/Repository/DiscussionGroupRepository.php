<?php

namespace App\Repository;

use App\Entity\DiscussionGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DiscussionGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscussionGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscussionGroup[]    findAll()
 * @method DiscussionGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DiscussionGroup::class);
    }

    // /**
    //  * @return DiscussionGroup[] Returns an array of DiscussionGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DiscussionGroup
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
