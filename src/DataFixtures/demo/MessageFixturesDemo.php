<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/07/2019
 * Time: 13:35
 */

namespace App\DataFixtures\demo;


use App\Entity\DiscussionGroup;
use App\Entity\Message;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MessageFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $gotaga = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $mickalow = $manager->getRepository(User::class)->findOneBy(["username" => "Mickalow"]);
        $robi = $manager->getRepository(User::class)->findOneBy(["username" => "Robi"]);
        $fortniteDiscussion = $manager->getRepository(DiscussionGroup::class)->findOneBy(["name" => "Vitality Fortnite"]);
        $managementDiscussion = $manager->getRepository(DiscussionGroup::class)->findOneBy(["name" => "Vitality management"]);
        $message = (new Message())
            ->setContent("De 16h à 17h c'est entrainement")
            ->setCreateAt(new DateTime("2019-07-11 12:00:00"))
            ->setIsRead(true)
            ->setDiscussionGroup($fortniteDiscussion)
            ->setTransmitter($gotaga);
        $manager->persist($message);
        $message = (new Message())
            ->setContent("Ok")
            ->setCreateAt(new DateTime("2019-07-11 12:04:00"))
            ->setIsRead(true)
            ->setDiscussionGroup($fortniteDiscussion)
            ->setTransmitter($robi);
        $manager->persist($message);
        $message = (new Message())
            ->setContent("Ok")
            ->setCreateAt(new DateTime("2019-07-11 12:05:00"))
            ->setIsRead(false)
            ->setDiscussionGroup($fortniteDiscussion)
            ->setTransmitter($mickalow);
        $manager->persist($message);
        $message = (new Message())
            ->setContent("Nous avons un planning chargé il va falloir s'organiser")
            ->setCreateAt(new DateTime("2019-07-11 18:00:00"))
            ->setIsRead(false)
            ->setDiscussionGroup($managementDiscussion)
            ->setTransmitter($gotaga);
        $manager->persist($message);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixturesDemo::class,
            DiscussionGroupFixturesDemo::class
        ];
    }

    public static function getGroups(): array
    {
        return ['demo'];
    }
}