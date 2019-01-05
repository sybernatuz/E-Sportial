<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 13:52
 */

namespace App\DataFixtures;


use App\Entity\Game;
use App\Entity\Play;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PlayFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $games = $manager->getRepository(Game::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 50; $i++) {
            $game = (new Play())
                ->setStartDate($faker->dateTime)
                ->setGame($faker->randomElement($games))
                ->setUser($faker->randomElement($users));
            $manager->persist($game);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
            UserFixtures::class
        ];
    }
}