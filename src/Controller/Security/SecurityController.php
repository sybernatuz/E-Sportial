<?php

namespace App\Controller\Security;

use App\Form\LoginType;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route(name="app_security_")
 */
class SecurityController extends AbstractController
{
    private $footerService;
    private $formFactory;

    /**
     * SecurityController constructor.
     * @param FooterService $footerService
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FooterService $footerService, FormFactoryInterface $formFactory)
    {
        $this->footerService = $footerService;
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_index');
        }

        // create login form
        $form = $this->formFactory->createNamed('', LoginType::class, [
            '_login_username' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}

}
