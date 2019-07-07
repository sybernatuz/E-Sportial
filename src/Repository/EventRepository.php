<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Game;
use App\Entity\Search\EventSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
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
     * Used for pagination
     * @param EventSearch $search
     * @return Query
     */
    public function findBySearchOrderByLastDate(EventSearch $search): Query
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.createdAt', 'DESC');

        if ($word = $search->getWord()) {
            $query->andWhere('j.name LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($location = $search->getLocation()) {
            $query->andWhere('e.location LIKE :location')
                ->setParameter('location', '%' . $location . '%');
        }

        if ($type = $search->getType()) {
            $query->leftJoin('j.type', 't')
                ->where('t.name = :type')
                ->setParameter(':type', $type->getName());
        }
        return $query->getQuery();
    }


    /**
     * @param int $eventsNumber
     * @return Event[] Returns an array of Recruitment objects
     */
    public function findByLastDate(int $eventsNumber)
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.startDate', 'DESC')
            ->setMaxResults($eventsNumber)
            ->getQuery()->getResult();
    }

    public function findByLastDateAndGame(Game $game)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('App\Entity\Party', 'p', Join::WITH, 'p.event = e.id')
            ->where('p.game = :game')
            ->setParameter(':game', $game)
            ->orderBy('e.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByParticipant(User $user, int $eventId)
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.participants', 'p')
            ->where('p.user = :user')
            ->setParameter(':user', $user)
            ->andwhere('e.id = :id')
            ->setParameter(':id', $eventId)
            ->getQuery()
            ->getResult();
    }
}
