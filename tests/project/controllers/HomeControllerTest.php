<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 23/01/2019
 * Time: 22:17
 */

namespace App\Tests\controllers;


use App\Tests\project\controllers\AbstractControllerTest;

class HomeControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return "/";
    }

    public function testTemplateInclusions() : void
    {
        $content = $this->client->getResponse()->getContent();
        $this->assertContains('home.js', $content);
        $this->assertContains('home.css', $content);
    }
}