<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:59
 */

namespace App\Tests\project\controllers;

/**
 * Class GameControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class GameControllerTest extends AbstractControllerTest
{

    public function testShow() : void
    {
        $this->standardTest('/game/call-of-duty', 'game_show');
    }

    public function testList() : void
    {
        $this->standardTest('/games', 'game_list');
    }
}