<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 23/01/2019
 * Time: 22:17
 */

namespace App\Tests\controllers;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testStatus()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTemplateInclusions()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $content = $client->getResponse()->getContent();
        $this->assertContains('home.js', $content);
        $this->assertContains('home.css', $content);
    }
}