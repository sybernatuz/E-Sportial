<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 12:29
 */

namespace App\Services;


use App\Form\Security\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FormService
{

    private $formFactory;
    private $authenticationUtils;

    public function __construct(FormFactoryInterface $formFactory, AuthenticationUtils $authenticationUtils)
    {
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function createLoginForm() : array
    {
        $formLogin = $this->formFactory->createNamed('', LoginType::class, [
            '_login_username' => $this->authenticationUtils->getLastUsername(),
        ]);
        return [
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
            'form' => $formLogin->createView()
        ];
    }

}