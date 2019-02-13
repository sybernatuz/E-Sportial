<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:25
 */

namespace App\Tests\project\controllers;

/**
 * Class SecurityControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class SecurityBackControllerTest extends AbstractControllerTest
{

    public function testList(): void
    {
        $this->standardTest('/admin/login', '');
    }

}