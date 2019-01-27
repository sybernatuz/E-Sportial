<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:58
 */

namespace App\Tests\project\controllers;

/**
 * Class GamesControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class GamesControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/games';
    }

    protected function getAssetName(): string
    {
        return 'games';
    }
}