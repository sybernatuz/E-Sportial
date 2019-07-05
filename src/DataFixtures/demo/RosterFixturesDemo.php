<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/07/2019
 * Time: 11:57
 */

namespace App\DataFixtures\demo;


use App\Entity\Game;
use App\Entity\Organization;
use App\Entity\Roster;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RosterFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $fortnite = $manager->getRepository(Game::class)->findOneBy(["name" => "Fortnite"]);
        $vitality = $manager->getRepository(Organization::class)->findOneBy(["name" => "Vitality"]);
        $gotaga = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $mickalow = $manager->getRepository(User::class)->findOneBy(["username" => "Mickalow"]);
        $robi = $manager->getRepository(User::class)->findOneBy(["username" => "Robi"]);
        $roster = (new Roster())
            ->setName("Fortnite")
            ->setCreatedAt(new DateTime())
            ->setDescription("The Vitality roster for Fortnite game")
            ->setGame($fortnite)
            ->setOrganization($vitality)
            ->addUser($gotaga)
            ->addUser($mickalow)
            ->addUser($robi);
        $manager->persist($roster);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixturesDemo::class,
            OrganizationFixturesDemo::class
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