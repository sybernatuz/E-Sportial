<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 18:21
 */

namespace App\DataFixtures\dev;


use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $usernames = [];
        $country = (new Country())
                    ->setFlagPath($faker->imageUrl())
                    ->setName($faker->name);
        $manager->persist($country);

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
                ->setRoles(["ROLE_USER"])
                ->setCountry($country);
            $manager->persist($user);
        }

        $user = (new User())
            ->setEmail("admin@gmail.com")
            ->setUsername("admin")
            ->setAge($faker->numberBetween(1, 100))
            ->setOnline($faker->boolean)
            ->setAvatar($faker->imageUrl())
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPro($faker->boolean)
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"])
            ->setCountry($country);
        $user->setPassword($this->encoder->encodePassword($user, "admin"));
        $manager->persist($user);

        $user = (new User())
            ->setEmail("user@gmail.com")
            ->setUsername("user")
            ->setAge($faker->numberBetween(1, 100))
            ->setOnline($faker->boolean)
            ->setAvatar($faker->imageUrl())
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setPro($faker->boolean)
            ->setRoles(["ROLE_USER"])
            ->setCountry($country);
        $user->setPassword($this->encoder->encodePassword($user, "user"));
        $manager->persist($user);

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