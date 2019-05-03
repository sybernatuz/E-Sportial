<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 03/05/19
 * Time: 22:03
 */

namespace App\Exceptions\DataConverter;


use Throwable;

class DataConverterJsonDecodeException extends DataConverterException
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        $message = sprintf('An error has occured');
        parent::__construct($message, $code, $previous);
    }
}