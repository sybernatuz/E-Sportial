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

class CountryFixturesDemo extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $france = (new Country())
            ->setName("France")
            ->setFlagPath("https://i.ebayimg.com/images/g/oakAAOSwXSJXOyQ~/s-l300.jpg");
        $manager->persist($france);

        $usa = (new Country())
            ->setName("USA")
            ->setFlagPath("https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/1280px-Flag_of_the_United_States.svg.png");
        $manager->persist($usa);

        $china = (new Country())
            ->setName("China")
            ->setFlagPath("https://upload.wikimedia.org/wikipedia/commons/f/fa/Flag_of_the_People%27s_Republic_of_China.svg");
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