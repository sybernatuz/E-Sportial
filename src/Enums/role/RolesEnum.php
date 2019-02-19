<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 19/02/2019
 * Time: 10:35
 */

namespace App\Enums\role;


use App\Enums\AbstractEnum;

class RolesEnum extends AbstractEnum
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
}