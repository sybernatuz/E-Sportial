<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 20:31
 */

namespace App\Exceptions\GameAccount;


use App\Entity\Game;
use App\Entity\GameAccount;
use Throwable;

class GameAccountNotFoundException extends GameAccountException
{
    public function __construct(Game $game, int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('The game account is not define for the game %s', $game->getName());
        parent::__construct($message, $code, $previous);
    }
}