<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 27/01/2019
 * Time: 01:31
 */

namespace App\Tests\project\services;


use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractServiceTest extends KernelTestCase
{
    protected static $service;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$container->get(self::getServiceClass());
    }

    protected abstract static function getServiceClass();
}