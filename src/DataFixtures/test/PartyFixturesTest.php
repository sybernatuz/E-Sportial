<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:02
 */

namespace App\DataFixtures\test;


use App\DataFixtures\dev\ResultFixtures;
use App\Entity\Event;
use App\Entity\Game;
use App\Entity\Party;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PartyFixturesTest extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $games = $manager->getRepository(Game::class)->findAll();
        $events = $manager->getRepository(Event::class)->findAll();
        for ($i = 0; $i < 100; $i++) {
            $game = (new Party())
                ->setDate($faker->dateTime)
                ->setGame($faker->randomElement($games))
                ->setEvent($faker->randomElement($events));
            $manager->persist($game);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            GameFixturesTest::class
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
        return ['dev'];
    }
}