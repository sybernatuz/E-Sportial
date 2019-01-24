<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:04
 */

namespace App\Tests\setup\mock;


use App\Entity\Game;

class GameMock
{
    /**
     * @var Game
     */
    static $game1;
    /**
     * @var Game
     */
    static $game2;
    /**
     * @var Game
     */
    static $game3;
    /**
     * @var Game
     */
    static $game4;
    /**
     * @var Game
     */
    static $game5;

    public static function init() : void
    {
        self::$game1 = self::createGame1();
        self::$game2 = self::createGame2();
        self::$game3 = self::createGame3();
        self::$game4 = self::createGame4();
        self::$game5 = self::createGame5();
    }

    private static function createGame1() : Game
    {
        return (new Game())
            ->setName("Fortnite")
            ->setDescription("Battle royale ou 100 joueurs s'affrontent")
            ->setPosterPath("images/image.jpg")
            ->setApiUrl("https://api.fortnitetracker.com/");
    }

    private static function createGame2() : Game
    {
        return (new Game())
            ->setName("Counter Strike")
            ->setDescription("Fps ou deux equipes s'affrontent")
            ->setPosterPath("images/image.jpg")
            ->setApiUrl("https://api.cs.com/");
    }

    private static function createGame3() : Game
    {
        return (new Game())
            ->setName("Call of duty")
            ->setDescription("Fps multijoueur")
            ->setPosterPath("images/image.jpg")
            ->setApiUrl("https://api.cod.com/");
    }

    private static function createGame4() : Game
    {
        return (new Game())
            ->setName("League of legend")
            ->setDescription("MOBA ou deux equipes de champions s'affrontent")
            ->setPosterPath("images/image.jpg")
            ->setApiUrl("https://api.lol.com/");
    }

    private static function createGame5() : Game
    {
        return (new Game())
            ->setName("World of warcraft")
            ->setDescription("MMORPG dans un monde ouvert")
            ->setPosterPath("images/image.jpg")
            ->setApiUrl("https://api.wow.com/");
    }
}