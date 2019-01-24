<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:59
 */

namespace App\Tests\project\controllers;


class GameControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/game/call-of-duty';
    }


    protected function getAssetName(): string
    {
        return 'game';
    }
}