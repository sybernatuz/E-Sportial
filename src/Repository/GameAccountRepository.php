<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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

    public function findByUserAndGame(User $user, Game $game) {
        $query = $this->createQueryBuilder('ga')
                    ->where('ga.gamer = :user AND ga.game = :game')
                    ->setParameter('user', $user)
                    ->setParameter('game', $game)
                    ->getQuery();

        try {
            return $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
