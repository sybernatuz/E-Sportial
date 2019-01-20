<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:00
 */

namespace App\DataFixtures;


use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $game = (new Game())
                ->setApiUrl($faker->url)
                ->setDescription($faker->text)
                ->setName($faker->name)
                ->setPosterPath($faker->imageUrl());
            $manager->persist($game);
        }
        $manager->flush();
    }
}