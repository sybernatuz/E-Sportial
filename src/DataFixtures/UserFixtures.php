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
use Faker\Generator;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $usernames = [];
        for ($i = 0; $i < 100; $i++)
        {
            $user = (new User())
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setUsername($this->getUniqueUsername($usernames, $faker))
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

    private function getUniqueUsername(array &$usernames, Generator $faker)
    {
        while (true) {
            $username = $faker->userName;
            if (!in_array($username, $usernames)) {
                $usernames[] = $username;
                return $username;
            }
        }
        return null;
    }
}