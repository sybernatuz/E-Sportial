<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Form\RetrieveForgotPasswordType;
use App\Handler\Security\ResetPasswordHandler;
use App\Services\FormService;
use App\Services\layout\FooterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route(name="app_security_")
 */
class SecurityController extends AbstractController
{
    private $footerService;
    private $formService;
    private $entityManager;
    private $resetPasswordHandler;
    private $translator;

    /**
     * SecurityController constructor.
     * @param FooterService $footerService
     * @param FormService $formService
     * @param EntityManagerInterface $entityManager
     * @param ResetPasswordHandler $resetPasswordHandler
     * @param TranslatorInterface $translator
     */
    public function __construct(
        FooterService $footerService,
        FormService $formService,
        EntityManagerInterface $entityManager,
        ResetPasswordHandler $resetPasswordHandler,
        TranslatorInterface $translator
    )
    {
        $this->entityManager = $entityManager;
        $this->footerService = $footerService;
        $this->formService = $formService;
        $this->resetPasswordHandler = $resetPasswordHandler;
        $this->translator = $translator;
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

    /**
     * @Route("/forgot-password", name="forgot_password")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function retrieveForgotPasswordAction(Request $request)
    {
        $form = $this->createForm(RetrieveForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            if (!$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email])) {
                $this->addFlash('error', $this->translator->trans('user.retrieve_by_email.error'));
                return $this->redirectToRoute('app_security_forgot_password');
            }

            try {
                $this->resetPasswordHandler->sendEmail($user);
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('user.send_mail.error'));
            }

            $this->addFlash('success', $this->translator->trans('user.send_mail.success'));
            return $this->redirectToRoute('app_security_forgot_password');
        }

       return $this->render('security/forgot_password.html.twig', [
            'form' => $form->createView(),
        ] + $this->footerService->process());
    }

    /**
     * @Route(path="/change-password/{id}/{resetPasswordToken}", name="change_password")
     * @param Request $request
     * @param User $user
     * @param string $resetPasswordToken
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, User $user, string $resetPasswordToken) {
        if($this->getUser()) {
            return $this->redirectToRoute('app_home_index');
        }

        if (!$user->isResetTokenValid($resetPasswordToken)) {
            throw $this->createNotFoundException($this->translator->trans('user.reset_password_token.incorrect'));
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->resetPasswordHandler->resetPassword($user, $form->get('password')->getData());
            return $this->redirectToRoute('app_security_login');
        }

        return $this->render('security/reset_password.html.twig', [
                'form' => $form->createView(),
            ] + $this->footerService->process());
    }

}
