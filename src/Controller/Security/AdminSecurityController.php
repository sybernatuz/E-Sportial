<?php

namespace App\Controller\Security;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route(path="/admin", name="app_security_admin_")
 */
class AdminSecurityController extends AbstractController
{
    private $formFactory;

    /**
     * AdminSecurityController constructor.
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @Route(path="/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAdmin(AuthenticationUtils $authenticationUtils): Response
    {
        // create login form
        $form = $this->formFactory->createNamed('', LoginType::class, [
            '_login_username' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/admin_login.html.twig', [
                'error' => $authenticationUtils->getLastAuthenticationError(),
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}

}
