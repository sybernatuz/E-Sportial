<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 12:48
 */

namespace App\Tests\project\controllers;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

abstract class AbstractControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp() : void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->request('GET', $this->getControllerUrl());
    }

    public function testStatus() : void
    {
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    protected abstract function getControllerUrl() : string;

}