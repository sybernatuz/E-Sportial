<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 31/12/2018
 * Time: 20:30
 */

namespace App\Objects;


class DataHolder
{
    private $data = [];

    public function put(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    public function getData() {
        return $this->data;
    }
}