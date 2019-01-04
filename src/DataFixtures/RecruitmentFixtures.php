<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/01/2019
 * Time: 22:43
 */

namespace App\DataFixtures;


use App\Entity\Organization;
use App\Entity\Recruitment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RecruitmentFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $organizations = $manager->getRepository(Organization::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            $isRecruited = $faker->boolean;
            if (!$isRecruited)
                continue;
            $startDate = $faker->dateTime;
            $faker->dateTimeBetween($startDate);
            $recruitment = (new Recruitment())
                ->setStartDate($startDate)
                ->setEndDate($faker->dateTimeBetween($startDate))
                ->setUser($user)
                ->setOrganization($faker->randomElement($organizations));
            $manager->persist($recruitment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OrganizationFixtures::class,
            UserFixtures::class
        ];
    }

}