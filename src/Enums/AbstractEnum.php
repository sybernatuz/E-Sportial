<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 19/01/2019
 * Time: 20:03
 */

namespace App\Enums;


use ReflectionClass;

abstract class AbstractEnum
{
    static function getValues() {
        try {
            $oClass = new ReflectionClass(static::class);
        } catch (\ReflectionException $e) {
            return [];
        }
        return $oClass->getConstants();
    }
}