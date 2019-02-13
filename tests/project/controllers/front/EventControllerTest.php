<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 16:18
 */

namespace App\Tests\project\controllers;

/**
 * Class EventControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class EventControllerTest extends AbstractControllerTest
{

    public function testList(): void
    {
        $this->standardTest('/events', 'event_list');
    }
}