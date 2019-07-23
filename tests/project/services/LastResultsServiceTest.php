<?php

use App\Services\home\LastResultsService;
use App\Tests\project\services\AbstractServiceTest;
use App\Tests\setup\mock\GameMock;
use App\Tests\setup\mock\PartyMock;

class LastResultsServiceTest extends AbstractServiceTest {

    function getServiceClass() : string
    {
        return LastResultsService::class;
    }

    public function testProcess()
    {
        $result = $this->service->process();
        $this->assertNotNull($result["lastPartiesGroupByGameName"]);
        $this->assertContains($result["lastPartiesGroupByGameName"][GameMock::$game1], PartyMock::$party1);
        $this->assertContains($result["lastPartiesGroupByGameName"][GameMock::$game1], PartyMock::$party2);
    }
}
