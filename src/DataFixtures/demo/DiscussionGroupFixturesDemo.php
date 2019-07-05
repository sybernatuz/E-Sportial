<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/07/2019
 * Time: 13:31
 */

namespace App\DataFixtures\demo;


use App\Entity\DiscussionGroup;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DiscussionGroupFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $gotaga = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $mickalow = $manager->getRepository(User::class)->findOneBy(["username" => "Mickalow"]);
        $robi = $manager->getRepository(User::class)->findOneBy(["username" => "Robi"]);
        $result = (new DiscussionGroup())
            ->setCreatedAt(new DateTime("2019-07-10 10:00:20"))
            ->setName("Vitality management")
            ->addUser($gotaga)
            ->addUser($robi);
        $manager->persist($result);
        $result = (new DiscussionGroup())
            ->setCreatedAt(new DateTime("2019-07-10 20:00:18"))
            ->setName("Vitality Fortnite")
            ->addUser($gotaga)
            ->addUser($robi)
            ->addUser($mickalow);
        $manager->persist($result);
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
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