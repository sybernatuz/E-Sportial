<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Entity\Roster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Roster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roster[]    findAll()
 * @method Roster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RosterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Roster::class);
    }


    public function findByTeamOrderedByName(Organization $team)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.organization = :organization')
            ->orderBy('r.name', 'ASC')
            ->setParameter('organization', $team)
            ->getQuery()
            ->getResult()
        ;
    }

}
