<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 12:32
 */

namespace App\DataFixtures\dev;


use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MessageFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 100; $i++) {
            $job = (new Message())
                ->setContent($faker->text(1000))
                ->setCreateAt($faker->dateTime)
                ->setIsRead($faker->boolean)
                ->setReceiver($faker->randomElement($users))
                ->setTransmitter($faker->randomElement($users));
            $manager->persist($job);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}