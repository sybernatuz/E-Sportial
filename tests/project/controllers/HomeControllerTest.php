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


    protected function getAssetName(): string
    {
        return 'home';
    }
}