<?php

namespace App\Repository;

use App\Entity\Search\Admin\UserSearchAdmin;
use App\Entity\Search\MemberSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
     * @param MemberSearch $search
     * @return Query
     */
    public function findBySearch(MemberSearch $search): Query
    {
        $query = $this->createQueryBuilder('u')
            ->select('u.slug, u.username, u.avatar, c.flagPath, c.name as flagName, count(s) as followers')
            ->innerJoin('u.country', 'c')
            ->leftJoin('u.subscriptions', 's')
            ->groupBy('u.id, c.id');

        if ($word = $search->getWord()) {
            $query->andWhere('u.username LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($country = $search->getCountry()) {
            $query->andWhere('c.name = :country')
                ->setParameter('country', $country->getName());
        }

        return $query->getQuery();
    }

    /**
     * Used for pagination
     * @param UserSearchAdmin $search
     * @return Query
     */
    public function findBySearchAdmin(UserSearchAdmin $search): Query
    {
        $query = $this->createQueryBuilder('u');

        if ($username = $search->getUsername()) {
            $query->andWhere('LOWER(u.username) LIKE LOWER(:username)')
                ->setParameter('username', '%' . $username . '%');
        }

        if ($email = $search->getEmail()) {
            $query->andWhere('LOWER(u.email) LIKE LOWER(:email)')
                ->setParameter('email', '%' . $email . '%');
        }

        if ($firstName = $search->getFirstName()) {
            $query->andWhere('LOWER(u.firstname) LIKE LOWER(:firstName)')
                ->setParameter('firstName', '%' . $firstName . '%');
        }

        if ($lastName = $search->getLastName()) {
            $query->andWhere('LOWER(u.lastname) LIKE LOWER(:lastName)')
                ->setParameter('lastName', '%' . $lastName . '%');
        }

        if ($age = $search->getAge()) {
            $query->andWhere('u.age = :age')
                ->setParameter('age', $age);
        }

        if ($online = $search->isOnline()) {
            $query->andWhere('u.online = :online')
                ->setParameter('online', $online);
        }

        return $query->getQuery();
    }

    /**
     * Used for the front authentification
     * @param string $username
     * @return User
     * @throws NonUniqueResultException
     */
    public function findByUsernameOrEmail(string $username): ?User
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
     * @throws NonUniqueResultException
     */
    public function findByUsernameOrEmailAdmin(string $username): ?User
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
