<?php


namespace App\Tests\project\services;


use App\Tests\setup\mock\AbstractMockInitializerTest;

abstract class AbstractServiceTest extends AbstractMockInitializerTest
{

    protected $service;

    public function setUp() {
        $this->service = self::bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository($this->getServiceClass());
    }

    protected abstract function getServiceClass() : string ;
}