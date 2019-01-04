<?php

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Party::class);
    }

    /**
     * @param $partiesNumber int
     * @return Party[]
     */
    public function findByLastResults($partiesNumber) : array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('App\Entity\Result', 'r', \Doctrine\ORM\Query\Expr\Join::WITH, 'r.party = p.id')
            ->orderBy('r.date', 'DESC')
            ->setMaxResults($partiesNumber * 2)
            ->getQuery()
            ->getResult();
    }
}
