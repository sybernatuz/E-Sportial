<?php

namespace App\Repository;

use App\Entity\Organization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Organization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organization[]    findAll()
 * @method Organization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Organization::class);
    }

    public function findByType(int $organizationsNumber, string $type) : array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter('type', $type)
            ->setMaxResults($organizationsNumber)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Organization
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
