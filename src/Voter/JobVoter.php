<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 05/03/2019
 * Time: 15:09
 */

namespace App\Voter;


use App\Entity\Job;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class JobVoter extends Voter
{

    const EDIT = "editJob";

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT]))
            return false;

        if (!$subject instanceof Job)
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
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($token, $subject);
        }
        return false;
    }

    private function canEdit(TokenInterface $token, Job $job) : bool
    {
        $loggedUser = $token->getUser();
        if (!$loggedUser instanceof User) {
            return false;
        }

        if ($job->getUser() != null)
            return $loggedUser->getId() == $job->getUser()->getId();
        return $loggedUser->getOrganization() === $job->getOrganization() && $loggedUser->getTeamOwner();
    }
}