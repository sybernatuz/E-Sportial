<?php


namespace App\DataFixtures\demo;


use App\DataFixtures\dev\OrganizationFixturesDemo;
use App\DataFixtures\dev\TypeFixtures;
use App\Entity\Event;
use App\Entity\Organization;
use App\Entity\Type;
use App\Enums\type\EventTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EventFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $vitality = $manager->getRepository(Organization::class)->findOneBy(["name" => "Vitality"]);
        $type = $manager->getRepository(Type::class)->findBy(['name' => EventTypeEnum::TOURNAMENT]);
        $event = (new Event())
            ->setLocation("Los Angeles Convention Center, Los Angeles, Californie, USA")
            ->setStartDate(new DateTime("2019-08-05"))
            ->setEndDate(new DateTime("2019-08-17"))
            ->setType($type)
            ->setCreatedAt(new DateTime())
            ->setName("Tournament E3 Fortnite")
            ->setPublished(true)
            ->setDescription("A Fortnite tournament will begin with the Vitality team")
            ->setOrganization($vitality);
        $manager->persist($event);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OrganizationFixturesDemo::class,
            TypeFixtures::class
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
        return ['demo'];
    }
}