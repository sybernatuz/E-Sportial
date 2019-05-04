<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\Search\GameSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
     * Used for pagination
     * @param GameSearch $search
     * @return Query
     */
    public function findBySearch(GameSearch $search): Query
    {
        $query = $this->createQueryBuilder('g');

        if ($word = $search->getWord()) {
            $query->andWhere('g.name LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        return $query->getQuery();
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

    /**
     * @param User $user
     * @param bool $returnQueryBuilder
     * @return mixed
     */
    public function findUserGames(User $user, bool $returnQueryBuilder = false) {
        $query = $this->createQueryBuilder('g')
            ->join(GameAccount::class, 'ga', 'WITH', 'ga.game = g.id')
            ->where('ga.gamer = :user')
            ->setParameter('user', $user)
            ->orderBy('g.name', 'ASC');

        if(!$returnQueryBuilder) {
            return $query->getQuery()
                         ->getResult();
        }

        return $query;
    }


}
