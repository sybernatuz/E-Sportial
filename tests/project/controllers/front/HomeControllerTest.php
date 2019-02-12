<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 23/01/2019
 * Time: 22:17
 */

namespace App\Tests\controllers;


use App\Tests\project\controllers\AbstractControllerTest;

/**
 * Class HomeControllerTest
 * @package App\Tests\controllers
 * @group Controller
 */
class HomeControllerTest extends AbstractControllerTest
{

    public function testIndex() : void
    {
        $this->standardTest('/', 'home');
    }
}