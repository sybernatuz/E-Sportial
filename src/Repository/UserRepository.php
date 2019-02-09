<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used for pagination
     * @return Query
     */
    public function findAllOrderedBySubscriptionsQuery() : Query {
        return $this->createQueryBuilder('u')
                    ->select('u.slug, u.username, u.avatar, c.flagPath, c.name as flagName, count(s) as followers')
                    ->innerJoin('u.country', 'c')
                    ->leftJoin('u.subscriptions', 's')
                    ->groupBy('u.id, c.id')
                    ->orderBy('followers', 'DESC')
                    ->getQuery();
    }

    /**
     * Used for the front authentification
     * @param string $username
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUsernameOrEmail(string $username) : ?User
    {
        return $this->createQueryBuilder('u')
                    ->where('u.username = :username')
                    ->orWhere('u.email = :username')
                    ->setParameter(':username', $username)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * Used for the back authentification
     * @param string $username
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUsernameOrEmailAdmin(string $username) : ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->orWhere('u.email = :username')
            ->andWhere('u.roles LIKE \'%ROLE_ADMIN%\'')
            ->setParameter(':username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
