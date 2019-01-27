<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 27/01/19
 * Time: 18:21
 */

namespace App\Listener;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * This method is called by the LogoutListener when a user has requested
     * to be logged out. Usually, you would unset session variables, or remove
     * cookies, etc.
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();
        if($user instanceof User) {
            $user->setOnline(false);
            $this->entityManager->flush();
        }
    }
}