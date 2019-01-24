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

    public function testAssetInclusion() : void
    {
        $content = $this->client->getResponse()->getContent();
        $assetName = $this->getAssetName();
        $this->assertContains($assetName . '.js', $content);
        $this->assertContains($assetName . '.css', $content);
    }

    public function testCommonAssetInclusion() : void
    {
        $content = $this->client->getResponse()->getContent();
        $this->assertContains('app.js', $content);
        $this->assertContains('app.css', $content);
    }

    protected abstract function getControllerUrl() : string;

    protected abstract function getAssetName() : string;

}