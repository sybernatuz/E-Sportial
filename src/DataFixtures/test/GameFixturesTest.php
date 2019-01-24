<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:19
 */

namespace App\DataFixtures\test;


use App\Tests\setup\mock\GameMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GameFixturesTest extends Fixture implements FixtureGroupInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        GameMock::init();

        $manager->persist(GameMock::$game1);
        $manager->persist(GameMock::$game2);
        $manager->persist(GameMock::$game3);
        $manager->persist(GameMock::$game4);
        $manager->persist(GameMock::$game5);

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
        return ['test'];
    }
}