<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 09:38
 */

namespace App\DataFixtures\test;


use App\Tests\setup\mock\UserMock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixturesTest extends Fixture implements FixtureGroupInterface
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        UserMock::init();

        UserMock::$user1->setPassword($this->encoder->encodePassword(UserMock::$user1, UserMock::$user1->getPassword()));
        $manager->persist(UserMock::$user1);

        UserMock::$admin1->setPassword($this->encoder->encodePassword(UserMock::$admin1, UserMock::$admin1->getPassword()));
        $manager->persist(UserMock::$admin1);

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
}