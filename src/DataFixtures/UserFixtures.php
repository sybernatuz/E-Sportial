<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 18:21
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++)
        {
            $user = (new User())
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setUsername($faker->userName)
                ->setAge($faker->numberBetween(1, 100))
                ->setOnline($faker->boolean)
                ->setAvatar($faker->imageUrl())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPro($faker->boolean)
                ->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}