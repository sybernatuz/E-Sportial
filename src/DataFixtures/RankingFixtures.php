<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:16
 */

namespace App\DataFixtures;


use App\Entity\Party;
use App\Entity\Ranking;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RankingFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $parties = $manager->getRepository(Party::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        foreach ($parties as $party)
            $this->createRankingsForParty($manager, $party, $users);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartyFixtures::class,
            UserFixtures::class
        ];
    }

    private function createRankingsForParty(ObjectManager &$manager, Party $party, array $users) {
        $faker = Factory::create();
        $playersNumber = $faker->numberBetween(10, 100);
        for ($i = 0; $i < $playersNumber; $i++) {
            $user = $faker->randomElement($users);
            $result = (new Ranking())
                ->setRank($i)
                ->setParty($party)
                ->setUser($user);
            $manager->persist($result);
            $this->removeUsedPlayer($user, $users);
        }
    }

    public function removeUsedPlayer(User $user, array &$users) {
        if (false !== $key = array_search($user, $users))
            unset($users[$key]);
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['dev'];
    }
}