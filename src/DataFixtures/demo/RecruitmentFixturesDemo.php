<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/07/2019
 * Time: 12:01
 */

namespace App\DataFixtures\demo;


use App\Entity\Organization;
use App\Entity\Recruitment;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RecruitmentFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $vitality = $manager->getRepository(Organization::class)->findOneBy(["name" => "Vitality"]);
        $gotaga = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $mickalow = $manager->getRepository(User::class)->findOneBy(["username" => "Mickalow"]);
        $robi = $manager->getRepository(User::class)->findOneBy(["username" => "Robi"]);
        $recruitmentGotaga = (new Recruitment())
            ->setStartDate(new DateTime("2018-08-31"))
            ->setEndDate(null)
            ->setUser($gotaga)
            ->setOrganization($vitality);
        $manager->persist($recruitmentGotaga);
        $recruitmentMickalow = (new Recruitment())
            ->setStartDate(new DateTime("2018-08-31"))
            ->setEndDate(null)
            ->setUser($mickalow)
            ->setOrganization($vitality);
        $manager->persist($recruitmentMickalow);
        $recruitmentRobi = (new Recruitment())
            ->setStartDate(new DateTime("2018-08-31"))
            ->setEndDate(null)
            ->setUser($robi)
            ->setOrganization($vitality);
        $manager->persist($recruitmentRobi);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OrganizationFixturesDemo::class,
            UserFixturesDemo::class
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