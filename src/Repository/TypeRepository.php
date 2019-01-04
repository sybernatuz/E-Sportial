<?php

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Type::class);
    }

     /**
      * @return Type[] Returns an array of Type objects
      */
    public function findByEntityName($entityName)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.entityName = :entityName')
            ->setParameter('entityName', $entityName)
            ->getQuery()
            ->getResult()
        ;
    }
}
