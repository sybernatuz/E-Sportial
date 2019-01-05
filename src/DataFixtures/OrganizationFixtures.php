<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:39
 */

namespace App\DataFixtures;


use App\Entity\Country;
use App\Entity\Organization;
use App\Entity\Type;
use App\Enums\type\EntityNameEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $countries = $manager->getRepository(Country::class)->findAll();
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
            $manager->persist($result);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
            TypeFixtures::class
        ];
    }
}