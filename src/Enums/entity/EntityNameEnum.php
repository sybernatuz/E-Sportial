<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 14:12
 */

namespace App\Enums\entity;


use App\Enums\AbstractEnum;

class EntityNameEnum extends AbstractEnum
{
    const ENTITY_NAME_JOB = "job";
    const ENTITY_NAME_ORGANIZATION = "organization";
    const ENTITY_NAME_EVENT = "event";
}