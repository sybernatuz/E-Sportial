<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:56
 */

namespace App\Tests\project\controllers;


class JobsControllerTest extends AbstractControllerTest
{

    protected function getControllerUrl(): string
    {
        return '/jobs';
    }

    protected function getAssetName(): string
    {
        return 'jobs';
    }
}