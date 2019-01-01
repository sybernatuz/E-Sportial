<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:02
 */

namespace App\DataFixtures;


use App\Entity\Game;
use App\Entity\Party;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PartyFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $games = $manager->getRepository(Game::class)->findAll();
        for ($i = 0; $i < 10; $i++) {
            $game = (new Party())
                ->setDate($faker->dateTime)
                ->setGame($faker->randomElement($games));
            $manager->persist($game);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            GameFixtures::class
        ];
    }
}