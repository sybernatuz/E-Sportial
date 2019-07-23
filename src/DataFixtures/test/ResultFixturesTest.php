<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:07
 */

namespace App\DataFixtures\dev;


use App\DataFixtures\test\PartyFixturesTest;
use App\DataFixtures\test\UserFixturesTest;
use App\Entity\Result;
use App\Entity\User;
use App\Tests\setup\mock\UserMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ResultFixturesTest extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        $user1 = $userRepository->findBy(['username' => UserMock::$user1->getUsername()])[0];
        $user2 = $userRepository->findBy(['username' => UserMock::$user2->getUsername()])[0];
        $subscription1 = (new Result())
            ->setUser($user2);
        $subscription2 = (new Result())
            ->setUser($user1);
        $manager->persist($subscription1);
        $manager->persist($subscription2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartyFixturesTest::class,
            UserFixturesTest::class
        ];
    }

    public function removePartyWhereTwoResults(array &$results, Result &$currentResult, array &$parties)
    {
        foreach ($results as $result) {
            if ($currentResult->getParty()->getId() == $result->getParty()->getId()) {
                if (false !== $key = array_search($result->getParty(), $parties)) {
                    unset($parties[$key]);
                    $currentResult->setDate($result->getDate());
                    break;
                }
            }
        }
        $results[] = $currentResult;
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}