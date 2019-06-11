<?php

namespace App\Repository;

use App\Entity\DiscussionGroup;
use App\Entity\User;
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

    /**
     * @param User $user
     * @return DiscussionGroup[] Returns an array of DiscussionGroup objects
     */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('d')
            ->join("d.users", "user")
            ->where('user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }


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
