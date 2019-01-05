<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param int $gamesNumber
     * @return Game[] Returns an array of Game objects
     */
    public function findByMostPopular(int $gamesNumber)
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('App\Entity\Play', 'p', \Doctrine\ORM\Query\Expr\Join::WITH, 'p.game = g.id')
            ->groupBy('g.id')
            ->orderBy('count(p.id)', 'DESC')
            ->setMaxResults($gamesNumber)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Game
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
