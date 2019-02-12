<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:56
 */

namespace App\Tests\project\controllers;

/**
 * Class JobControllerTest
 * @package App\Tests\project\controllers
 * @group Controller
 */
class JobControllerTest extends AbstractControllerTest
{

    public function testList() : void
    {
        $this->standardTest('/jobs', 'job_list');
    }
}