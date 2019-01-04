<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:35
 */

namespace App\DataFixtures;


use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CountryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $result = (new Country())
                ->setName($faker->country)
                ->setFlagPath($faker->imageUrl());
            $manager->persist($result);
        }
        $manager->flush();
    }
}