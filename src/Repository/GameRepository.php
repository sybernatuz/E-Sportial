<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function findByOrderByNameAsc(int $gamesNumber)
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.name', 'ASC')
            ->setMaxResults($gamesNumber)
            ->getQuery()
            ->getResult();
    }

    public function findByName(string $name, int $gamesNumber, int $page = 1)
    {
        return $this->createQueryBuilder('g')
            ->where('g.name LIKE :name')
            ->setParameter(':name', '%'.$name.'%')
            ->setFirstResult($gamesNumber * $page - $gamesNumber)
            ->setMaxResults($gamesNumber)
            ->getQuery()
            ->getResult();
    }

    public function getPaginationByName(string $name, int $gamesNumber)
    {
        try {
            return $this->createQueryBuilder('g')
                ->select('COUNT(g.id) / ' . $gamesNumber)
                ->where('LOWER(g.name) LIKE LOWER(:name)')
                ->setParameter(':name', '%' . $name . '%')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
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

    public function getPagination(int $gamesNumber)
    {
        try {
            return $this->createQueryBuilder('g')
                ->select('COUNT(g.id) / ' . $gamesNumber)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }


}
