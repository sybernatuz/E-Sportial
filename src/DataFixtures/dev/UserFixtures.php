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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
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
        $countries = $manager->getRepository(Country::class)->findAll();

        for ($i = 0; $i < 100; $i++)
        {
            $user = (new User())
                ->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setUsername($this->getUniqueUsername($usernames, $faker))
                ->setDescription($faker->text)
                ->setAge($faker->numberBetween(1, 100))
                ->setOnline($faker->boolean)
                ->setAvatar($faker->imageUrl())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setPro($faker->boolean)
                ->setRoles(["ROLE_USER"])
                ->setTeamOwner(false)
                ->setCountry($faker->randomElement($countries));
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
            ->setTeamOwner(false)
            ->setCountry($faker->randomElement($countries));
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
            ->setTeamOwner(false)
            ->setCountry($faker->randomElement($countries));
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

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CountryFixtures::class
        ];
    }
}