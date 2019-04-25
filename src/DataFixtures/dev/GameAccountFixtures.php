<?php

namespace App\DataFixtures\dev;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class GameAccountFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $games = $manager->getRepository(Game::class)->findAll();

        foreach ($users as $user) {
            for($i = 0; $i <= 3; $i++) {
                $gameAccount = new GameAccount();
                $gameAccount->setGamer($user)
                            ->setPseudo($user->getUsername())
                            ->setGame($faker->randomElement($games));
                $manager->persist($gameAccount);
            }
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
            GameFixtures::class,
            UserFixtures::class
        ];
    }
}
