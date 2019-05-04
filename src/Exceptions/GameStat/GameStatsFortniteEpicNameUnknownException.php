<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 20:22
 */

namespace App\Exceptions\GameStat;

use Throwable;

class GameStatsFortniteEpicNameUnknownException extends GameStatsException
{
    public function __construct(string $pseudo, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The Epic username %s doesn\'t exist', $pseudo);
        parent::__construct($message, $code, $previous);
    }
}