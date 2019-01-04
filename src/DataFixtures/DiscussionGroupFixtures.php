<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:31
 */

namespace App\DataFixtures;


use App\Entity\DiscussionGroup;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class DiscussionGroupFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $result = (new DiscussionGroup())
                ->setCreatedAt($faker->dateTime)
                ->setName($faker->name)
                ->addUser($faker->randomElement($users));
            $manager->persist($result);
        }
        $manager->flush();
    }


    public function getDependencies()
    {

    }
}