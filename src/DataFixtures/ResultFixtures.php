<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:07
 */

namespace App\DataFixtures;


use App\Entity\Party;
use App\Entity\Result;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ResultFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $parties = $manager->getRepository(Party::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 10; $i++) {
            $game = (new Result())
                ->setDate($faker->dateTime)
                ->setDeaths($faker->numberBetween(0, 20))
                ->setKills($faker->numberBetween(0, 20))
                ->setDuration($faker->dateTime)
                ->setScore($faker->randomNumber())
                ->setParty($faker->randomElement($parties))
                ->setUser($faker->randomElement($users));

            $manager->persist($game);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartyFixtures::class,
            UserFixtures::class
        ];
    }
}