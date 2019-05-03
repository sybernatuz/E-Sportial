<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 20:17
 */

namespace App\Exceptions\GameStat;


use Throwable;

class GameStatException extends \RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}