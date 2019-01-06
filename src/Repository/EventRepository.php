<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @param int $eventsNumber
     * @param string $type
     * @return Event[] Returns an array of Recruitment objects
     */
    public function findByLastDateAndType(int $eventsNumber, string $type)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type)
            ->orderBy('e.startDate', 'DESC')
            ->setMaxResults($eventsNumber)
            ->getQuery()
            ->getResult()
            ;
    }
}
