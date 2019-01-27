<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:19
 */

namespace App\Tests\project\controllers;

/**
 * Class LoginFrontControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class LoginFrontControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/login';
    }

    protected function getAssetName(): string
    {
        return '';
    }
}