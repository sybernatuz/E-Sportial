<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:07
 */

namespace App\DataFixtures;


use App\Entity\Party;
use App\Entity\Result;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ResultFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $parties = $manager->getRepository(Party::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $results = [];
        for ($i = 0; $i < 20; $i++) {
            $result = (new Result())
                ->setDate($faker->dateTime)
                ->setDeaths($faker->numberBetween(0, 20))
                ->setKills($faker->numberBetween(0, 20))
                ->setDuration($faker->dateTime)
                ->setScore($faker->randomNumber())
                ->setParty($faker->randomElement($parties))
                ->setUser($faker->randomElement($users));
            $this->removePartyWhereTwoResults($results, $result, $parties);
            $manager->persist($result);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartyFixtures::class,
            UserFixtures::class
        ];
    }

    public function removePartyWhereTwoResults(array &$results, Result &$currentResult, array &$parties) {
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
}