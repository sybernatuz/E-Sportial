<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 02/07/19
 * Time: 19:43
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UserExistConstraint
 * @package App\Validator\Constraints
 * @Annotation
 */
class UserExistConstraint extends Constraint
{
    public $message = 'Member "{{ username }}" not exist.';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}