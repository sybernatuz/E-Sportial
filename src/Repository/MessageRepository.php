<?php

namespace App\Repository;

use App\Entity\Message;
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
    public function findByReceiverAndNotRead($user) : array
    {
        return $this->createQueryBuilder('m')
            ->where('m.isRead = false')
            ->andWhere('m.receiver = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findByReceiverOrTransmitterOrderByDate($user) : array
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
