<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 18:21
 */

namespace App\DataFixtures\demo;


use App\Entity\Country;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixturesDemo extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $france = $manager->getRepository(Country::class)->findBy(['name' => 'France']);
        $gotaga = (new User())
            ->setEmail("gotaga@gmail.com")
            ->setUsername("Gotaga")
            ->setAge(25)
            ->setOnline(false)
            ->setAvatar("")
            ->setFirstname("Corentin")
            ->setLastname("Houssein")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($france);
        $gotaga->setPassword($this->encoder->encodePassword($gotaga, "gotaga"));
        $manager->persist($gotaga);

        $usa = $manager->getRepository(Country::class)->findBy(['name' => 'USA']);
        $ninja = (new User())
            ->setEmail("ninja@gmail.com")
            ->setUsername("Ninja")
            ->setAge(27)
            ->setOnline(false)
            ->setAvatar("")
            ->setFirstname("Tyler")
            ->setLastname("Blevins")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($usa);
        $ninja->setPassword($this->encoder->encodePassword($ninja, "ninja"));
        $manager->persist($ninja);

        $admin = (new User())
            ->setEmail("admin@gmail.com")
            ->setUsername("admin")
            ->setAge(30)
            ->setOnline(false)
            ->setAvatar('')
            ->setFirstname('Jean')
            ->setLastname('Charles')
            ->setPro(false)
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"])
            ->setCountry($france);
        $admin->setPassword($this->encoder->encodePassword($admin, "admin"));
        $manager->persist($admin);

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
        return ['demo'];
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
            CountryFixturesDemo::class
        ];
    }
}