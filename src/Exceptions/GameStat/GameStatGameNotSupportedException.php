<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 20:40
 */

namespace App\Exceptions\GameStat;


use Throwable;

class GameStatGameNotSupportedException extends GameStatsException
{
    public function __construct(string $gameName, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The game %s is not yet supported', $gameName);
        parent::__construct($message, $code, $previous);
    }
}