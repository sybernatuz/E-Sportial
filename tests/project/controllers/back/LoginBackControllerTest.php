<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:25
 */

namespace App\Tests\project\controllers;

/**
 * Class LoginBackControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class LoginBackControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/admin/login';
    }

    protected function getAssetName(): string
    {
        return '';
    }
}