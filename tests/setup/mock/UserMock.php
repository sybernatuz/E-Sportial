<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 09:41
 */

namespace App\Tests\setup\mock;


use App\Entity\User;

class UserMock
{
    /**
     * @var User
     */
    static $user1;
    /**
     * @var User
     */
    static $user2;
    /**
     * @var User
     */
    static $admin1;

    public static function init() : void
    {
        self::$user1 = self::createUser1();
        self::$user2 = self::createUser2();
        self::$admin1 = self::createAdmin1();
    }

    private static function createUser1() : User
    {
        return (new User())
            ->setEmail("jean@gmail.com")
            ->setPassword("jean1234")
            ->setUsername("jeanno")
            ->setAge(25)
            ->setOnline(false)
            ->setAvatar("images/avatar-man.png")
            ->setLastname("Jean")
            ->setFirstname("Jacque")
            ->setPro(false)
            ->setRoles(["ROLE_USER"])
            ->setCountry(CountryMock::$country1);
    }

    private static function createUser2() : User
    {
        return (new User())
            ->setEmail("user@gmail.com")
            ->setPassword("user")
            ->setUsername("user")
            ->setAge(20)
            ->setOnline(false)
            ->setAvatar("images/avatar-man.png")
            ->setLastname("last")
            ->setFirstname("first")
            ->setPro(false)
            ->setRoles(["ROLE_USER"])
            ->setCountry(CountryMock::$country2);
    }

    private static function createAdmin1() : User
    {
        return (new User())
            ->setEmail("admin1@gmail.com")
            ->setPassword("admin1admin")
            ->setUsername("admin1")
            ->setAge(25)
            ->setOnline(false)
            ->setAvatar("images/avatar-man.png")
            ->setLastname("Thor")
            ->setFirstname("Chirac")
            ->setPro(false)
            ->setRoles(["ROLE_ADMIN", "ROLE_USER"])
            ->setCountry(CountryMock::$country1);
    }
}