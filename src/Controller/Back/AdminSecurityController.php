<?php

namespace App\Controller\Back;

use App\Services\FormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route(path="/admin", name="app_security_admin_")
 */
class AdminSecurityController extends AbstractController
{
    private $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * @Route(path="/login", name="login")
     * @return Response
     */
    public function loginAdmin(): Response
    {
        return $this->render('pages/back/security/admin_login.html.twig', $this->formService->createLoginForm());
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}

}
