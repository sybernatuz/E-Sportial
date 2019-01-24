<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 08/01/2019
 * Time: 15:46
 */

namespace App\DataFixtures\dev;


use App\Entity\Organization;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $organizations = $manager->getRepository(Organization::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $subscription = (new Subscription())
                ->setSubscriber($faker->randomElement($users));
            $this->setOneOrganizationOrOneUser($subscription, $faker, $users, $organizations);
            $manager->persist($subscription);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            OrganizationFixtures::class
        ];
    }

    private function setOneOrganizationOrOneUser(Subscription &$subscription, Generator $faker, array $users, array $organizations) {
        $isUser = $faker->boolean;
        if ($isUser)
            $subscription->setUser($faker->randomElement($users));
        else
            $subscription->setOrganization($faker->randomElement($organizations));
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
}