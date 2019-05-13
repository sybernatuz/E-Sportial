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
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class SubscriptionHandler
{
    private $entityManager;
    private $subscriptionRepository;
    private $templating;

    /**
     * SubscriptionHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(EntityManagerInterface $entityManager, SubscriptionRepository $subscriptionRepository, EngineInterface $templating)
    {
        $this->entityManager = $entityManager;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->templating = $templating;
    }

    /**
     * @param User|null $subscriber
     * @param User|Organization $member
     * @return array | bool
     */
    public function subscribe($subscriber, $member)
    {
        if (!$subscriber || $subscriber === $member)
            return $this->getDataToReturn(false);

        $subscription = $this->subscriptionRepository->findBySubscriberAndMember($subscriber, $member);
        if($subscription)
            return $this->getDataToReturn(false);

        $subscription = new Subscription();
        $subscription->setSubscriber($subscriber);
        if (get_class($member) == User::class) {
            $subscription->setUser($member);
        } else {
            $subscription->setOrganization($member);
        }
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
        return $this->getDataToReturn(true, $member);
    }

    /**
     * @param User|null $subscriber
     * @param User|Organization $member
     * @return array|bool
     */
    public function unsubscribe($subscriber, $member)
    {
        if(!$subscriber || $subscriber === $member)
            return $this->getDataToReturn(false);

        $subscription = $this->subscriptionRepository->findBySubscriberAndMember($subscriber, $member);
        if(!$subscription)
            return $this->getDataToReturn(false);

        $this->entityManager->remove($subscription);
        $this->entityManager->flush();
        return $this->getDataToReturn(true, $member);
    }

    /**
     * @param $state
     * @param $member
     * @return array | bool
     */
    private function getDataToReturn($state, $member = null)
    {
        if(!$state || !$member) {
            return false;
        }

        $followersHtml = $this->templating->render('modules/front/common/modal/followers_list.html.twig', [
            "followers" => $this->subscriptionRepository->getListOfSubscriber($member)
        ]);
        $countFollowers = $member->getSubscriptions()->count();
        return ["state" => $state, "counter" => $countFollowers, "followersHtml" => $followersHtml];
    }
}