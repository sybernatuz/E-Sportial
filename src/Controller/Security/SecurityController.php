<?php

namespace App\Controller\Security;

use App\Services\FormService;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route(name="app_security_")
 */
class SecurityController extends AbstractController
{
    private $footerService;
    private $formService;

    public function __construct(FooterService $footerService, FormService $formService)
    {
        $this->footerService = $footerService;
        $this->formService = $formService;
    }

    /**
     * @Route(path="/login", name="login")
     * @return Response
     */
    public function login(): Response
    {
        if ($this->getUser())
            return $this->redirectToRoute('app_home_index');

        return $this->render('security/login.html.twig',
            $this->formService->createLoginForm() +
            $this->footerService->process());
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}

}
