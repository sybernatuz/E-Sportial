<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:35
 */

namespace App\DataFixtures\demo;


use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CountryFixturesDemo extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $france = (new Country())
            ->setName("France")
            ->setFlagPath("");
        $manager->persist($france);

        $usa = (new Country())
            ->setName("USA")
            ->setFlagPath("");
        $manager->persist($usa);

        $china = (new Country())
            ->setName("China")
            ->setFlagPath("");
        $manager->persist($china);

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
}