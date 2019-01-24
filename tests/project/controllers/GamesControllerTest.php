<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:58
 */

namespace App\Tests\project\controllers;


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