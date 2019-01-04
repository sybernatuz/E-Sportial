<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:16
 */

namespace App\DataFixtures;


use App\Entity\Party;
use App\Entity\Ranking;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RankingFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $parties = $manager->getRepository(Party::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $result = (new Ranking())
                ->setRank($faker->randomNumber())
                ->setParty($faker->randomElement($parties))
                ->setUser($faker->randomElement($users));
            $manager->persist($result);
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