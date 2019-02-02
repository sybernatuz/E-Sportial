<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 22/01/19
 * Time: 21:27
 */

namespace App\Security;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FrontLoginAuthenticator extends LoginAuthenticator
{
    private $userRepository;

    /**
     * FrontLoginAuthenticator constructor.
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TranslatorInterface $translator
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        TranslatorInterface $translator,
        UserRepository $userRepository)
    {
        parent::__construct($entityManager, $router, $csrfTokenManager, $passwordEncoder, $translator);
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return bool|mixed
     */
    protected function getSupports(Request $request)
    {
        return 'app_security_login' === $request->attributes->get('_route');
    }

    /**
     * @return mixed|string
     */
    protected function getLoginPath()
    {
        return $this->router->generate('app_security_login');
    }

    /**
     * @param UserInterface $user
     * @param $credentials
     * @return bool|mixed
     */
    protected function userValidator(UserInterface $user, $credentials)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @return mixed|RedirectResponse
     */
    protected function getRedirectionResponse()
    {
        return new RedirectResponse($this->router->generate('app_home_index'));
    }

    /**
     * @param $credentials
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function findUserByCredentials($credentials)
    {
        return $this->userRepository->findByUsernameOrEmail($credentials['username']);
    }
}