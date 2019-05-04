<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 21:35
 */

namespace App\Exceptions\GameStat;


use Throwable;

class GameStatsFortniteDataNotFoundException extends GameStatsException
{
    public function __construct(string $pseudo, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('No data found for the Epic username %s', $pseudo);
        parent::__construct($message, $code, $previous);
    }
}