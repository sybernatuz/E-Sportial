<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findAllOrderByPopularity(int $firstResult, int $maxResults) {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
           ->setMaxResults($maxResults);

        if($firstResult) {
            $qb->setFirstResult($firstResult);
        }

        $paginator = new Paginator($qb);
        $counter = count($paginator);

        return $paginator;
    }

    /**
     * Used for the front authentification
     * @param string $username
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUsernameOrEmail(string $username) {
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
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUsernameOrEmailAdmin(string $username) {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->orWhere('u.email = :username')
            ->andWhere('u.roles LIKE :role')
            ->setParameter(':username', $username)
            ->setParameter('role', '%ROLE_ADMIN%')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
