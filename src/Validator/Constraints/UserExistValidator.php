<?php

namespace App\Validator\Constraints;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UserExistValidator extends ConstraintValidator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof UserExist) {
            throw new UnexpectedTypeException($constraint, UserExist::class);
        }

        $user = $this->userRepository->findTeamMember($object->getTeam(), $object->getUsername());

        if(!$user) {
            $this->context->buildViolation($constraint->message)
                ->atPath('username')
                ->setParameter('{{ username }}', $object->getUsername())
                ->addViolation();
            return false;
        }
        return true;
    }
}