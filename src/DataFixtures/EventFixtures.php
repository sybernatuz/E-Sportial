<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 06/01/2019
 * Time: 16:40
 */

namespace App\DataFixtures;


use App\Entity\Event;
use App\Entity\Organization;
use App\Entity\Type;
use App\Enums\type\EntityNameEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $organizations = $manager->getRepository(Organization::class)->findAll();
        $types = $manager->getRepository(Type::class)->findBy(['entityName' => EntityNameEnum::ENTITY_NAME_EVENT]);
        for ($i = 0; $i < 20; $i++) {
            $startDate = $faker->dateTime;
            $event = (new Event())
                ->setLocation($faker->streetAddress)
                ->setStartDate($startDate)
                ->setEndDate($faker->dateTimeBetween($startDate))
                ->setType($faker->randomElement($types))
                ->setCreatedAt($faker->dateTime)
                ->setName($faker->name)
                ->setPublished($faker->boolean)
                ->setDescription($faker->text)
                ->setOrganization($faker->randomElement($organizations));
            $manager->persist($event);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OrganizationFixtures::class,
            TypeFixtures::class
        ];
    }
}