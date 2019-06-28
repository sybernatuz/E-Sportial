<?php

namespace App\Repository;

use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getListOfSubscriptions(User $user) {
        return $this->createQueryBuilder('s')
                    ->select('u')
                    ->join(User::class, 'u', 'WITH', 's.user = u.id')
                    ->where("s.subscriber = :user")
                    ->setParameter("user", $user)
                    ->getQuery()->getResult();
    }

    /**
     * @param $member
     * @return mixed
     */
    public function getListOfSubscriber($member) {
        $query = $this->createQueryBuilder('s')
            ->select('u.username, u.avatar, u.slug')
            ->join(User::class, 'u', 'WITH', 's.subscriber = u.id');

        if(get_class($member) == User::class) {
            $query->where("s.user = :member");
        } else {
            $query->where("s.organization = :member");
        }

        return $query->setParameter("member", $member)
            ->getQuery()->getResult();
    }

    /**
     * @param User $subscriber
     * @param $member
     * @return mixed|null
     */
    public function findBySubscriberAndMember(User $subscriber, $member) {
        $query = $this->createQueryBuilder('s');

        if(get_class($member) == User::class) {
            $query->where("s.user = :member");
        } else {
            $query->where("s.organization = :member");
        }

        $query->andWhere("s.subscriber = :subscriber")
              ->setParameter("member", $member)
              ->setParameter("subscriber", $subscriber);

        try {
            return $query->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
