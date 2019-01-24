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
    const USER_1_EMAIL = "jean@gmail.com";
    const USER_1_PASSWORD = "jean1234";
    const USER_1_USERNAME = "jeanno";
    const USER_1_AGE = 25;
    const USER_1_ONLINE = false;
    const USER_1_AVATAR = "images/avatar-man.png";
    const USER_1_FIRST_NAME = "Jean";
    const USER_1_LAST_NAME = "Jacque";
    const USER_1_PRO = false;
    const USER_1_ROLE = ["ROLE_USER"];

    const ADMIN_1_EMAIL = "admin1@gmail.com";
    const ADMIN_1_PASSWORD = "admin1admin";
    const ADMIN_1_USERNAME = "admin1";
    const ADMIN_1_AGE = 25;
    const ADMIN_1_ONLINE = false;
    const ADMIN_1_AVATAR = "images/avatar-man.png";
    const ADMIN_1_FIRST_NAME = "Thor";
    const ADMIN_1_LAST_NAME = "Chirac";
    const ADMIN_1_PRO = false;
    const ADMIN_1_ROLE = ["ROLE_ADMIN", "ROLE_USER"];

    /**
     * @var User
     */
    static $user1;
    /**
     * @var User
     */
    static $admin1;

    public static function init() : void
    {
        self::$user1 = self::createUser1();
        self::$admin1 = self::createAdmin1();
    }

    private static function createUser1() : User
    {
        return (new User())
            ->setEmail(self::USER_1_EMAIL)
            ->setPassword(self::USER_1_PASSWORD)
            ->setUsername(self::USER_1_USERNAME)
            ->setAge(self::USER_1_AGE)
            ->setOnline(self::USER_1_ONLINE)
            ->setAvatar(self::USER_1_AVATAR)
            ->setLastname(self::USER_1_LAST_NAME)
            ->setFirstname(self::USER_1_FIRST_NAME)
            ->setPro(self::USER_1_PRO)
            ->setRoles(self::USER_1_ROLE);

    }

    private static function createAdmin1() : User
    {
        return (new User())
            ->setEmail(self::ADMIN_1_EMAIL)
            ->setPassword(self::ADMIN_1_PASSWORD)
            ->setUsername(self::ADMIN_1_USERNAME)
            ->setAge(self::ADMIN_1_AGE)
            ->setOnline(self::ADMIN_1_ONLINE)
            ->setAvatar(self::ADMIN_1_AVATAR)
            ->setLastname(self::ADMIN_1_LAST_NAME)
            ->setFirstname(self::ADMIN_1_FIRST_NAME)
            ->setPro(self::ADMIN_1_PRO)
            ->setRoles(self::ADMIN_1_ROLE);

    }
}