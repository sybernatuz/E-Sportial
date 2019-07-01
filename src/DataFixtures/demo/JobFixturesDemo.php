<?php


namespace App\DataFixtures\demo;


use App\DataFixtures\dev\GameFixtures;
use App\DataFixtures\dev\OrganizationFixtures;
use App\DataFixtures\dev\TypeFixtures;
use App\DataFixtures\dev\UserFixtures;
use App\Entity\Job;
use App\Entity\Organization;
use App\Entity\Type;
use App\Entity\User;
use App\Enums\entity\EntityNameEnum;
use App\Enums\type\JobTypeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

class JobFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $type = $manager->getRepository(Type::class)->findOneBy(["entityName" => EntityNameEnum::ENTITY_NAME_JOB, "name" => JobTypeEnum::WORK]);
        $vitality = $manager->getRepository(Organization::class)->findOneBy(["name" => "Vitality"]);
        $user = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $job = (new Job())
            ->setTitle("Looking for Fortnite player")
            ->setDescription("The vitality team is looking for an experimented Fortnite player with 1000 top1 minimum")
            ->setCreatedAt(new DateTime())
            ->setDuration(30)
            ->setSalary(1000)
            ->setLocation("Paris")
            ->setOrganization($vitality)
            ->setType($type);
        $manager->persist($job);
        $job = (new Job())
            ->setDescription("Looking for League of Legends player")
            ->setTitle("I'm looking for an experimented fortnite player with a diamond rank")
            ->setCreatedAt(new DateTime())
            ->setDuration(30)
            ->setSalary(1000)
            ->setLocation("Paris")
            ->setUser($user);
        $manager->persist($job);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TypeFixtures::class,
            OrganizationFixtures::class,
            UserFixtures::class,
            GameFixtures::class
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