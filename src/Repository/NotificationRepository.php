<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 29/06/19
 * Time: 21:18
 */

namespace App\Repository;


use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function findByTypeOrderByDate(string $type, User $user) : array
    {
        return $this->createQueryBuilder('n')
            ->where('n.type = :type')
            ->andWhere('n.user = :user')
            ->setParameter('type', $type)
            ->setParameter('user', $user)
            ->orderBy('n.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}