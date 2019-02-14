<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 16:52
 */

namespace App\DataFixtures\test;


use App\Tests\setup\mock\CountryMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixturesTest extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        CountryMock::init();

        $manager->persist(CountryMock::$country1);
        $manager->persist(CountryMock::$country2);

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
        return ["test"];
    }
}