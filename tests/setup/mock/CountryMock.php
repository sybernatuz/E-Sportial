<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 16:53
 */

namespace App\Tests\setup\mock;


use App\Entity\Country;

class CountryMock
{

    /**
     * @var Country
     */
    public static $country1;

    /**
     * @var Country
     */
    public static $country2;

    public static function init() : void
    {
        self::$country1 = self::createCountry1();
        self::$country2 = self::createCountry2();
    }

    private static function createCountry1() : Country
    {
        return (new Country())
            ->setName("France")
            ->setFlagPath("images/country-flag.png");
    }

    private static function createCountry2() : Country
    {
        return (new Country())
            ->setName("China")
            ->setFlagPath("images/country-flag.png");
    }
}