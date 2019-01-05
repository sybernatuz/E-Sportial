<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 13:34
 */

namespace App\Services\common;


use App\Objects\DataHolder;
use App\Repository\GameRepository;

class FooterService
{
    private const GAMES_NUMBER = 5;

    private $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function process(DataHolder $finalDataHolder) {
        $mostPopularGames = $this->gameRepository->findByMostPopular(self::GAMES_NUMBER);
        $finalDataHolder->put('footerGames', $mostPopularGames);
    }
}