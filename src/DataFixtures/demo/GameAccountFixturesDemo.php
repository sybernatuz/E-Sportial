<?php


namespace App\DataFixtures\demo;

use App\Entity\Game;
use App\Entity\GameAccount;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GameAccountFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $fortnite = $manager->getRepository(Game::class)->findOneBy(["name" => "Fortnite"]);
        $lol = $manager->getRepository(Game::class)->findOneBy(["name" => "League of Legends"]);

        $gameAccount = (new GameAccount())
            ->setGamer($user)
            ->setPseudo("GotagaTV")
            ->setGame($fortnite);
        $manager->persist($gameAccount);

        $gameAccount = (new GameAccount())
            ->setGamer($user)
            ->setPseudo("Gotaga")
            ->setGame($lol);
        $manager->persist($gameAccount);

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
        return ['demo'];
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
            GameFixturesDemo::class,
            UserFixturesDemo::class
        ];
    }
}