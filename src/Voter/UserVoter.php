<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 06/02/2019
 * Time: 16:52
 */

namespace App\Voter;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{

    const EDIT = 'editUser';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject) : bool
    {
        if (!in_array($attribute, [self::EDIT]))
            return false;

        if (!$subject instanceof User)
            return false;

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) : bool
    {
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($token, $subject);
        }
        return false;
    }

    private function canEdit(TokenInterface $token, User $user) : bool
    {
        $loggedUser = $token->getUser();
        if (!$loggedUser instanceof User) {
            return false;
        }
        return $loggedUser->getId() == $user->getId();
    }
}