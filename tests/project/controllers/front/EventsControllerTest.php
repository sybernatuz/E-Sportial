<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 16:18
 */

namespace App\Tests\project\controllers;

/**
 * Class EventsControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class EventsControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/events';
    }

    protected function getAssetName(): string
    {
        return 'events';
    }
}