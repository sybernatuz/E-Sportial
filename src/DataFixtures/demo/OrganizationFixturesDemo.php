<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 14:39
 */

namespace App\DataFixtures\demo;


use App\Entity\Country;
use App\Entity\Organization;
use App\Entity\Type;
use App\Entity\User;
use App\Enums\entity\EntityNameEnum;
use App\Enums\type\OrganizationTypeEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class OrganizationFixturesDemo extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $france = $manager->getRepository(Country::class)->findOneBy(["name" => "France"]);
        $gotaga = $manager->getRepository(User::class)->findOneBy(["username" => "Gotaga"]);
        $type = $manager->getRepository(Type::class)->findOneBy(["name" => OrganizationTypeEnum::TEAM]);

        $vitality = (new Organization())
            ->setName("Vitality")
            ->setCreatedAt(new DateTime("2015-12-09"))
            ->setCountry($france)
            ->setLogoPath("https://upload.wikimedia.org/wikipedia/fr/3/30/Team_Vitality_Logo_2018.png")
            ->setDescription("La Team Vitality est un club de sport électronique francais fondée par Fabien Devide, Corentin Houssein et Kevin Georges. Faisant ses débuts sur la scène Call of Duty en 2013 puis sur Call of Duty: Black Ops II, la Team Vitality s'étend ensuite vers la scène FIFA en 2014 puis League of Legends, où elle joue dans les European League of Legends Championship Series (EU LCS), au printemps 2016 après le rachat de la place de l'équipe Gambit Gaming en LCS1. L’expansion de la structure se poursuit ensuite avec l'acquisition d'équipes sur des jeux comme : Rainbow Six, PUBG, Rocket League, Street Fighter V,Formula 1, Fortnite Battle Royale, CS:GO et la série FIFA.")
            ->setType($type)
            ->setVerify(true);

        $gotaga->setTeamOwner(true);
        $vitality->addUser($gotaga);
        $manager->persist($vitality);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CountryFixtures::class,
            TypeFixtures::class,
            UserFixtures::class
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