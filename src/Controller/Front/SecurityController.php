<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\Security\ResetPasswordType;
use App\Form\Security\RetrieveForgotPasswordType;
use App\Handler\Security\ResetPasswordHandler;
use App\Repository\UserRepository;
use App\Services\FormService;
use App\Services\layout\FooterService;
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
    private $resetPasswordHandler;
    private $translator;
    private $userRepository;

    /**
     * SecurityController constructor.
     * @param FooterService $footerService
     * @param FormService $formService
     * @param ResetPasswordHandler $resetPasswordHandler
     * @param TranslatorInterface $translator
     * @param UserRepository $userRepository
     */
    public function __construct(
            FooterService $footerService,
            FormService $formService,
            ResetPasswordHandler $resetPasswordHandler,
            TranslatorInterface $translator,
            UserRepository $userRepository
        )
    {
        $this->footerService = $footerService;
        $this->formService = $formService;
        $this->resetPasswordHandler = $resetPasswordHandler;
        $this->translator = $translator;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(path="/login", name="login")
     * @return Response
     */
    public function login(): Response
    {
        if ($this->getUser())
            return $this->redirectToRoute('app_home_index');

        return $this->render('pages/front/security/login.html.twig',
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

            if (!$user = $this->userRepository->findOneBy(['email' => $email])) {
                $this->addFlash('error', $this->translator->trans('user.retrieve_by_email.error'));
            } else {
                ($this->resetPasswordHandler->handle($user)) ?
                    $this->addFlash('success', $this->translator->trans('user.send_mail.success')) :
                    $this->addFlash('error', $this->translator->trans('user.send_mail.error'));
            }

        }

        return $this->render('pages/front/security/forgot_password.html.twig', [
               'form' => $form->createView()
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

        return $this->render('pages/front/security/reset_password.html.twig', [
                'form' => $form->createView(),
            ] + $this->footerService->process());
    }

}
