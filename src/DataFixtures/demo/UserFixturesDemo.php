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
        $france = $manager->getRepository(Country::class)->findOneBy(['name' => 'France']);
        $gotaga = (new User())
            ->setEmail("gotaga@gmail.com")
            ->setUsername("Gotaga")
            ->setAge(25)
            ->setOnline(false)
            ->setAvatar("https://erwan.bjsolutions.fr/wp-content/uploads/2019/01/gotaga-profil.png")
            ->setFirstname("Corentin")
            ->setLastname("Houssein")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($france)
            ->setTeamOwner(true);
        $gotaga->setPassword($this->encoder->encodePassword($gotaga, "gotaga"));
        $manager->persist($gotaga);

        $mickalow = (new User())
            ->setEmail("mickalow@gmail.com")
            ->setUsername("Mickalow")
            ->setAge(26)
            ->setOnline(false)
            ->setAvatar("https://proconfig.fr/wp-content/uploads/2018/12/Mickalow.jpg")
            ->setFirstname("Mickaël")
            ->setLastname("Maruin")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($france)
            ->setTeamOwner(false);
        $mickalow->setPassword($this->encoder->encodePassword($gotaga, "mickalow"));
        $manager->persist($mickalow);

        $robi = (new User())
            ->setEmail("robi@gmail.com")
            ->setUsername("Robi")
            ->setAge(30)
            ->setOnline(false)
            ->setAvatar("https://gamepedia.cursecdn.com/fortnite_esports_gamepedia_en/3/34/Robi.png")
            ->setFirstname("Maxime")
            ->setLastname("Dambrine")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($france)
            ->setTeamOwner(false);
        $robi->setPassword($this->encoder->encodePassword($robi, "robi"));
        $manager->persist($robi);

        $jacquie = (new User())
            ->setEmail("jacquie@gmail.com")
            ->setUsername("Jacquie")
            ->setAge(30)
            ->setOnline(false)
            ->setAvatar("https://banner2.kisspng.com/20180716/lra/kisspng-logo-person-user-person-icon-5b4d2bd2236ca6.6010202115317841461451.jpg")
            ->setFirstname("Jacquie")
            ->setLastname("La Fripouille")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($france)
            ->setTeamOwner(false);
        $jacquie->setPassword($this->encoder->encodePassword($jacquie, "jacquie"));
        $manager->persist($jacquie);

        $usa = $manager->getRepository(Country::class)->findOneBy(['name' => 'USA']);
        $ninja = (new User())
            ->setEmail("ninja@gmail.com")
            ->setUsername("Ninja")
            ->setAge(27)
            ->setOnline(false)
            ->setAvatar("https://images-na.ssl-images-amazon.com/images/I/41%2BuGkOgtKL.jpg")
            ->setFirstname("Tyler")
            ->setLastname("Blevins")
            ->setPro(true)
            ->setRoles(["ROLE_USER"])
            ->setCountry($usa)
            ->setTeamOwner(false);
        $ninja->setPassword($this->encoder->encodePassword($ninja, "ninja"));
        $manager->persist($ninja);

        $admin = (new User())
            ->setEmail("admin@gmail.com")
            ->setUsername("admin")
            ->setAge(30)
            ->setOnline(false)
            ->setAvatar('https://banner2.kisspng.com/20180716/lra/kisspng-logo-person-user-person-icon-5b4d2bd2236ca6.6010202115317841461451.jpg')
            ->setFirstname('Jean')
            ->setLastname('Charles')
            ->setPro(false)
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"])
            ->setCountry($france)
            ->setTeamOwner(false);
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