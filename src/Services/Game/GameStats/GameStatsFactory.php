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
     * @return GameStatsInterface
     */
    public static function create(Game $game) : GameStatsInterface {
        switch ($game->getSlug()) {
            case "fortnite":
                return new FortniteGameStatsService();
            default:
                throw new GameStatGameNotSupportedException($game->getName());
        }
    }
}