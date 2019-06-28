<?php


namespace App\DataFixtures\demo;


use App\DataFixtures\dev\GameFixtures;
use App\DataFixtures\dev\OrganizationFixtures;
use App\DataFixtures\dev\TypeFixtures;
use App\DataFixtures\dev\UserFixtures;
use App\Entity\Job;
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

        $user = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $job = (new Job())
            ->setTitle("Recherche d'un joueur Fortnite")
            ->setDescription("Je recherche actuellement un joueur experimenté de fortnite ayant un minimum de 1000 top 1")
            ->setCreatedAt(new DateTime())
            ->setDuration(30)
            ->setSalary(1000)
            ->setLocation("Paris")
            ->setUser($user)
            ->setType($type);
        $manager->persist($job);
        $job = (new Job())
            ->setDescription("Recherche d'un joueur League of Legends")
            ->setTitle("Je recherche actuellement un joueur experimenté de fortnite ayant un rang diamant")
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

    private function setUserOrOrganization(Generator $faker, Job &$job, array $users, array $organizations)
    {
        $user = $faker->boolean;
        if ($user)
            $job->setUser($faker->randomElement($users));
        else
            $job->setOrganization($faker->randomElement($organizations));
    }

    private function setGameIfTypeCoaching(Generator $faker, Job &$job, array $games, array $types)
    {
        $type = $faker->randomElement($types);
        $job->setType($type);
        if ($type->getName() == JobTypeEnum::COACHING)
            $job->setGame($faker->randomElement($games));
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