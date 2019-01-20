<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/01/2019
 * Time: 22:30
 */

namespace App\DataFixtures;


use App\Entity\Game;
use App\Entity\Job;
use App\Entity\Organization;
use App\Entity\Type;
use App\Entity\User;
use App\Enums\entity\EntityNameEnum;
use App\Enums\type\JobTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class JobFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $types = $manager->getRepository(Type::class)->findBy(["entityName" => EntityNameEnum::ENTITY_NAME_JOB]);
        $organizations = $manager->getRepository(Organization::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $games = $manager->getRepository(Game::class)->findAll();
        for ($i = 0; $i < 50; $i++) {
            $job = (new Job())
                ->setDescription($faker->text(1000))
                ->setTitle($faker->jobTitle)
                ->setCreatedAt($faker->dateTime)
                ->setDuration($faker->numberBetween(1, 365))
                ->setSalary($faker->randomFloat(2, 10, 1000))
                ->setLocation($faker->city);
            $this->setGameIfTypeCoaching($faker, $job, $games, $types);
            $this->setUserOrOrganization($faker, $job, $users, $organizations);
            $manager->persist($job);
        }
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
}