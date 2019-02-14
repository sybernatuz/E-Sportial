<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 10:02
 */

namespace App\DataFixtures\test;


use App\Entity\Subscription;
use App\Entity\User;
use App\Tests\setup\mock\SubscriptionMock;
use App\Tests\setup\mock\UserMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionFixturesTest extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        SubscriptionMock::init();

        $userRepository = $manager->getRepository(User::class);
        $user1 = $userRepository->findBy(['username' => UserMock::$user1->getUsername()])[0];
        $user2 = $userRepository->findBy(['username' => UserMock::$user2->getUsername()])[0];
        $subscription1 = (new Subscription())
            ->setSubscriber($user1)
            ->setUser($user2);
        $subscription2 = (new Subscription())
            ->setSubscriber($user2)
            ->setUser($user1);
        $manager->persist($subscription1);
        $manager->persist($subscription2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixturesTest::class,
        ];
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}