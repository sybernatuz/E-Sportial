<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 04/05/19
 * Time: 15:39
 */

namespace App\Services\Game\GameStats;


use App\Entity\Game;
use App\Exceptions\GameStat\GameStatGameNotSupportedException;

class GameStatsFactory
{
    /**
     * @param Game $game
     * @return mixed
     */
    public static function create(Game $game) {
        $gameSlug = str_replace('-', '_', $game->getSlug());

        switch ($gameSlug) {
            case "fortnite":
                return new FortniteGameStatsService();
            default:
                throw new GameStatGameNotSupportedException($game->getName());
        }
    }
}