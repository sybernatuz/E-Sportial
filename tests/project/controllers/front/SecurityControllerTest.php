<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:19
 */

namespace App\Tests\project\controllers;

/**
 * Class SecurityControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class SecurityControllerTest extends AbstractControllerTest
{

    public function testLogin() : void
    {
        $this->standardTest('/login', '');
    }
}