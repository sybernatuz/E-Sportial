<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @param $user
     * @return Message[]
     */
    public function findByDiscussionGroupAndNotRead(User $user) : array
    {
        return $this->createQueryBuilder('m')
            ->join("m.discussionGroup", "d")
            ->join("d.users", "user")
            ->andWhere("user = :user")
            ->andWhere('m.transmitter != :user')
            ->setParameter('user', $user)
            ->andwhere('m.isRead = false')
            ->getQuery()
            ->getResult();
    }

    public function findByReceiverOrTransmitterOrderByDate(User $user) : array
    {
        return $this->createQueryBuilder('m')
            ->where('m.receiver = :user')
            ->orWhere('m.transmitter = :user')
            ->setParameter('user', $user)
            ->orderBy('m.createAt', 'desc')
            ->getQuery()
            ->getResult();
    }
}
