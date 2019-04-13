<?php

namespace App\DataFixtures\dev;

use App\Entity\Organization;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $organizations = $manager->getRepository(Organization::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $subscription = (new Subscription())->setSubscriber($faker->randomElement($users));
            if($i > 25) {
                $subscription->setUser($faker->randomElement($users));
            } else {
                $subscription->setOrganization($faker->randomElement($organizations));
            }
            $manager->persist($subscription);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['dev'];
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            OrganizationFixtures::class,
            UserFixtures::class
        ];
    }
}
