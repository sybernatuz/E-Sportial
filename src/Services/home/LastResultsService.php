<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 18:44
 */

namespace App\Services\home;


use App\Objects\DataHolder;
use App\Repository\PartyRepository;
use App\Repository\ResultRepository;

class LastResultsService
{
    private const LAST_RESULTS_NUMBER = 3;

    private $resultRepository;
    private $partyRepository;

    public function __construct(ResultRepository $resultRepository, PartyRepository $partyRepository)
    {
        $this->resultRepository = $resultRepository;
        $this->partyRepository = $partyRepository;
    }

    public function process(DataHolder $finalDataHolder) : void
    {
        $lastResultsIds = $this->resultRepository->findIdsByLastDateGroupByAndLimit("party", self::LAST_RESULTS_NUMBER);
        $lastParties = $this->partyRepository->findByPartiesIds($lastResultsIds);
        $lastPartiesGroupByGameName = [];
        foreach ($lastParties as $lastParty) {
            $gameName = $lastParty->getGame()->getName();
            if (!array_key_exists($gameName, $lastPartiesGroupByGameName))
                $lastPartiesGroupByGame[$gameName] = [];
            $lastPartiesGroupByGameName[$gameName][] = $lastParty;
        }
        $finalDataHolder->put("lastPartiesGroupByGame", $lastPartiesGroupByGameName);
    }
}