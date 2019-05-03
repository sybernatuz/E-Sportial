<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 01/05/19
 * Time: 15:28
 */

namespace App\Utils;


class DataConverterUtil
{
    /**
     * @param $object
     * @return mixed
     */
    public static function StdClassToArray($object) {
        return json_decode(json_encode($object, true));
    }
}