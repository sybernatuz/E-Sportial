<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 18:44
 */

namespace App\Services\home;


use App\Repository\PartyRepository;

class LastResultsService
{
    private const LAST_RESULTS_NUMBER = 3;

    private $partyRepository;

    public function __construct(PartyRepository $partyRepository)
    {
        $this->partyRepository = $partyRepository;
    }

    public function process() : array
    {
        $lastParties = $this->partyRepository->findByLastResults(self::LAST_RESULTS_NUMBER);
        $lastPartiesGroupByGameName = $this->groupLastPartiesByGameName($lastParties);
        return ["lastPartiesGroupByGameName" => $lastPartiesGroupByGameName];
    }

    private function groupLastPartiesByGameName(array $lastParties) : array
    {
        $lastPartiesGroupByGameName = [];
        foreach ($lastParties as $lastParty) {
            $gameName = $lastParty->getGame()->getName();
            if (!array_key_exists($gameName, $lastPartiesGroupByGameName))
                $lastPartiesGroupByGame[$gameName] = [];
            $lastPartiesGroupByGameName[$gameName][] = $lastParty;
        }
        return $lastPartiesGroupByGameName;
    }
}