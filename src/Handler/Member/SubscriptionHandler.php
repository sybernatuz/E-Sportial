<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 13/02/19
 * Time: 22:14
 */

namespace App\Handler\Member;

use App\Entity\Organization;
use App\Entity\Subscription;
use App\Entity\User;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionHandler
{
    private $entityManager;
    private $subscriptionRepository;

    /**
     * SubscriptionHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(EntityManagerInterface $entityManager, SubscriptionRepository $subscriptionRepository)
    {
        $this->entityManager = $entityManager;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @param User|null $subscriber
     * @param User|Organization $member
     * @return array
     */
    public function subscribe($subscriber, $member)
    {
        if (!$subscriber || $subscriber === $member)
            return $this->getDataToReturn(false, null);

        $subscription = $this->subscriptionRepository->findBySubscriberAndMember($subscriber, $member);
        if ($subscription)
            return $this->getDataToReturn(false, null);

        $subscription = new Subscription();
        $subscription->setSubscriber($subscriber);
        if (get_class($member) == User::class) {
            $subscription->setUser($member);
        } else {
            $subscription->setOrganization($member);
        }
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
        return $this->getDataToReturn(true, $this->getSubscriptionCounter($member));
    }

    /**
     * @param User|null $subscriber
     * @param User|Organization $member
     * @return array
     */
    public function unsubscribe($subscriber, $member)
    {
        if(!$subscriber || $subscriber === $member)
            return $this->getDataToReturn(false, null);

        $subscription = $this->subscriptionRepository->findBySubscriberAndMember($subscriber, $member);
        if (!$subscription)
            return $this->getDataToReturn(false, null);

        $this->entityManager->remove($subscription);
        $this->entityManager->flush();
        return $this->getDataToReturn(true, $this->getSubscriptionCounter($member));

    }

    /**
     * @param $member
     * @return mixed
     */
    private function getSubscriptionCounter($member)
    {
        return $member->getSubscriptions()->count();
    }

    /**
     * @param $state
     * @param $counter
     * @return array
     */
    private function getDataToReturn($state, $counter)
    {
        return $object = ["state" => $state, "counter" => $counter];
    }
}