<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 08/01/2019
 * Time: 15:42
 */

namespace App\DataFixtures;


use App\Entity\Game;
use App\Entity\Organization;
use App\Entity\Roster;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RosterFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $games = $manager->getRepository(Game::class)->findAll();
        $organizations = $manager->getRepository(Organization::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $result = (new Roster())
                ->setName($faker->name)
                ->setCreatedAt($faker->dateTime)
                ->setDescription($faker->text(1000))
                ->setGame($faker->randomElement($games))
                ->setOrganization($faker->randomElement($organizations));
            $manager->persist($result);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GameFixtures::class,
            OrganizationFixtures::class
        ];
    }
}