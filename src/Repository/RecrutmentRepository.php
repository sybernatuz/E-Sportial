<?php

namespace App\Repository;

use App\Entity\Recrutment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Recrutment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recrutment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recrutment[]    findAll()
 * @method Recrutment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecrutmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recrutment::class);
    }

    // /**
    //  * @return Recrutment[] Returns an array of Recrutment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recrutment
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
