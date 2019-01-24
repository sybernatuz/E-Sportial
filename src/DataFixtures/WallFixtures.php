<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 04/01/2019
 * Time: 22:04
 */

namespace App\DataFixtures;


use App\Entity\Organization;
use App\Entity\User;
use App\Entity\Wall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class WallFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $organizations = $manager->getRepository(Organization::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 0; $i < 20; $i++) {
            $wall = (new Wall())
                ->setEnable($faker->boolean);
            $this->setUserOrOrganization($faker, $wall, $users, $organizations);
            $manager->persist($wall);
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

    private function setUserOrOrganization(Generator $faker, Wall &$wall, array &$users, array &$organizations)
    {
        $user = $faker->boolean;
        if ($user) {
            $user = $faker->randomElement($users);
            $wall->setUser($user);
            $this->removeUsedReferenceEntity($users, $user);
        } else {
            $organization = $faker->randomElement($organizations);
            $wall->setOrganization($organization);
            $this->removeUsedReferenceEntity($organizations, $organization);
        }
    }

    public function removeUsedReferenceEntity(array &$array, $entity)
    {
        if (false !== $key = array_search($entity, $array))
            unset($array[$key]);
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