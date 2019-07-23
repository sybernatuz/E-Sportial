<?php


namespace App\Tests\setup\mock;


use App\Entity\Result;
use DateTime;

class ResultMock
{
    static $result1;

    static $result2;

    public static function init() : void
    {
        self::$result1 = self::createParty1();
        self::$result2 = self::createParty2();
    }

    static function createParty1()
    {
        return (new Result())
            ->setDate(new DateTime())
            ->setUser(UserMock::$user1)
            ->setScore(7500);
    }
    
    static function createParty2()
    {
        return (new Result())
            ->setDate(new DateTime())
            ->setUser(UserMock::$user2)
            ->setScore(2000);
    }
}