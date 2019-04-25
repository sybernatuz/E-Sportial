<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameAccount[]    findAll()
 * @method GameAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameAccountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameAccount::class);
    }

    public function findUserGames(User $user ) {
        return $this->createQueryBuilder('ga')
            ->select('g')
            ->join(User::class, 'u', 'WITH', 'ga.gamer = u.id')
            ->join(Game::class, 'g', 'WITH', 'ga.game = g.id')
            ->where('ga.gamer = :user')
            ->setParameter('user', $user)
            ->orderBy('g.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
