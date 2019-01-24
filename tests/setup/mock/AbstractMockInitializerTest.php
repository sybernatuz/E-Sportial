<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:00
 */

namespace App\Tests\setup\mock;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractMockInitializerTest extends KernelTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        UserMock::init();
        GameMock::init();
    }
}