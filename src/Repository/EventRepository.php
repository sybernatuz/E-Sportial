<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
            ->where('t.name LIKE :type')
            ->setParameter(':type', '%'.$type.'%')
            ->orderBy('e.startDate', 'DESC')
            ->setMaxResults($eventsNumber)
            ->getQuery()
            ->getResult();
    }

    public function getPaginationByType(int $eventsNumber, string $type)
    {
        try {
            return $this->createQueryBuilder('e')
                ->select('COUNT(e.id) / '. $eventsNumber)
                ->leftJoin('e.type', 't')
                ->where('t.name LIKE :type')
                ->setParameter(':type', '%'.$type.'%')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findByNameAndLocationAndTypeOrderByLastDate(string $name, string $location, string $type, int $eventsNumber, int $page = 1)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.type', 't')
            ->where('t.name LIKE :type')
            ->andwhere('LOWER(e.name) LIKE LOWER(:name)')
            ->andWhere('LOWER(e.location) LIKE LOWER(:location)')
            ->setParameter(':type', '%'.$type.'%')
            ->setParameter(':name', '%'.$name.'%')
            ->setParameter(':location', '%'.$location.'%')
            ->orderBy('e.createdAt', 'DESC')
            ->setFirstResult($eventsNumber * $page - $eventsNumber)
            ->setMaxResults($eventsNumber)
            ->getQuery()
            ->getResult();
    }

    public function getPaginationByNameAndLocationAndType(string $name, string $location, string $type, int $eventsNumber)
    {
        try {
            return $this->createQueryBuilder('e')
                ->select('COUNT(e.id) / ' . $eventsNumber)
                ->leftJoin('e.type', 't')
                ->where('t.name LIKE :type')
                ->andwhere('LOWER(e.name) LIKE LOWER(:name)')
                ->andWhere('LOWER(e.location) LIKE LOWER(:location)')
                ->setParameter(':type', '%'.$type.'%')
                ->setParameter(':name', '%' . $name . '%')
                ->setParameter(':location', '%' . $location . '%')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
