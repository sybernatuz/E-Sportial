<?php


namespace App\Tests\setup\mock;


use App\Entity\Party;
use DateTime;

class PartyMock
{

    static $party1;

    static $party2;

    public static function init() : void
    {
        self::$party1 = self::createParty1();
        self::$party2 = self::createParty2();
    }

    static function createParty1()
    {
        return (new Party())
            ->setDate(new DateTime())
            ->setGame(GameMock::$game1)
            ->addUser(UserMock::$user1)
            ->addUser(UserMock::$user2)
            ->addResult(ResultMock::$result1)
            ->addResult(ResultMock::$result2);
    }

    static function createParty2()
    {
        return (new Party())
            ->setDate(new DateTime())
            ->setGame(GameMock::$game1)
            ->addUser(UserMock::$user1)
            ->addUser(UserMock::$user2)
            ->addResult(ResultMock::$result1)
            ->addResult(ResultMock::$result2);
    }
}