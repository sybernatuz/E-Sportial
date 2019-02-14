<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 09:38
 */

namespace App\DataFixtures\test;


use App\Entity\Country;
use App\Tests\setup\mock\CountryMock;
use App\Tests\setup\mock\UserMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixturesTest extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        UserMock::init();

        $countryRepository = $manager->getRepository(Country::class);
        $country1 = $countryRepository->findBy(['name' => CountryMock::$country1->getName()])[0];
        $country2 = $countryRepository->findBy(['name' => CountryMock::$country2->getName()])[0];

        UserMock::$user1->setPassword($this->encoder->encodePassword(UserMock::$user1, UserMock::$user1->getPassword()));
        $user1 = UserMock::$user1;
        $user1->setCountry($country1);
        $manager->persist($user1);

        UserMock::$user1->setPassword($this->encoder->encodePassword(UserMock::$user2, UserMock::$user2->getPassword()));
        $user2 = UserMock::$user2;
        $user2->setCountry($country2);
        $manager->persist($user2);

        UserMock::$admin1->setPassword($this->encoder->encodePassword(UserMock::$admin1, UserMock::$admin1->getPassword()));
        $admin1 = UserMock::$admin1;
        $admin1->setCountry($country1);
        $manager->persist($admin1);

        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ["test"];
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CountryFixturesTest::class
        ];
    }
}