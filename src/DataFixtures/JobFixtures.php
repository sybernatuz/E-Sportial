<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/01/2019
 * Time: 22:30
 */

namespace App\DataFixtures;


use App\Entity\Job;
use App\Entity\Organization;
use App\Entity\Type;
use App\Entity\User;
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
        $types = $manager->getRepository(Type::class)->findBy(["entityName" => JobTypeEnum::ENTITY_NAME]);
        $organizations = $manager->getRepository(Organization::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 50; $i++) {
            $job = (new Job())
                ->setDescription($faker->text)
                ->setTitle($faker->title)
                ->setCreatedAt($faker->dateTime)
                ->setDuration($faker->numberBetween(1, 365))
                ->setType($faker->randomElement($types))
                ->setSalary($faker->randomFloat(2));
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
            UserFixtures::class
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
}