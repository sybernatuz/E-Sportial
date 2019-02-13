<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 15:34
 */

namespace App\Tests\project\repositories;


use App\Tests\setup\mock\AbstractMockInitializerTest;

abstract class AbstractRepositoryTest extends AbstractMockInitializerTest
{
    protected $repository;

    protected function setUp() : void
    {
        $this->repository = self::bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository($this->getClassName());
    }

    protected abstract function getClassName(): string;
}