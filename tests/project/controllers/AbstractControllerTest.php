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

    protected function standardTest(string $routeUrl, string $assetName) : void
    {
        $this->initClient($routeUrl);
        $this->statusTest();
        $this->assetInclusionTest($assetName);
        $this->commonAssetInclusionTest();
    }

    private function initClient(string $routeUrl) : void
    {
        $this->client = static::createClient();
        $this->client->request('GET', $routeUrl);
    }

    private function statusTest() : void
    {
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    private function assetInclusionTest(string $assetName) : void
    {
        $content = $this->client->getResponse()->getContent();
        $this->assertContains($assetName . '.js', $content);
        $this->assertContains($assetName . '.css', $content);
    }

    private function commonAssetInclusionTest() : void
    {
        $content = $this->client->getResponse()->getContent();
        $this->assertContains('app.js', $content);
        $this->assertContains('app.css', $content);
    }

}