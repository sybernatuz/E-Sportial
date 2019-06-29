<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:39
 */

namespace App\DataFixtures\dev;


use App\Entity\Country;
use App\Entity\Organization;
use App\Entity\Type;
use App\Entity\User;
use App\Enums\entity\EntityNameEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $countries = $manager->getRepository(Country::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $types = $manager->getRepository(Type::class)->findBy(["entityName" => EntityNameEnum::ENTITY_NAME_ORGANIZATION]);
        for ($i = 0; $i < 20; $i++) {
            $result = (new Organization())
                ->setName($faker->name)
                ->setCreatedAt($faker->dateTime)
                ->setCountry($faker->randomElement($countries))
                ->setLogoPath($faker->imageUrl())
                ->setDescription($faker->text)
                ->setType($faker->randomElement($types))
                ->setVerify($faker->boolean);
            for($y = 0; $y <= 5; $y++) {
                $user = $faker->randomElement($users);
                if($y == 0) {
                    $user->setTeamOwner(true);
                } else {
                    $user->setTeamOwner(false);
                }

                $result->addUser($user);
            }
            $manager->persist($result);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
            TypeFixtures::class,
            UserFixtures::class
        ];
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