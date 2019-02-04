<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 02/02/19
 * Time: 11:37
 */

namespace App\Handler\Security;


use App\Entity\User;
use App\Services\MailerService;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResetPasswordHandler
{
    private $mailerService;
    private $entityManager;
    private $passwordEncoder;
    private $translator;

    /**
     * ResetPasswordHandler constructor.
     * @param MailerService $mailerService
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TranslatorInterface $translator
     */
    public function __construct(
        MailerService $mailerService,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        TranslatorInterface $translator
    )
    {
        $this->mailerService = $mailerService;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->translator = $translator;
    }

    /**
     * @param User $user
     * @return string
     */
    public function sendEmail(User $user) : string
    {
        $resetPasswordToken = null;
        try {
            $resetPasswordToken = $user->generateResetToken(new DateInterval('P' . 1 . 'D'));
        } catch (Exception $e) {

        }
        $params = [
            'name' => $user->getLastName(),
            'resetPasswordToken' => $resetPasswordToken,
            'userId' => $user->getId()
        ];

        $this->entityManager->flush();

        $result = $this->mailerService->sendMail($this->translator->trans('mail.reset_password.subject'), 'gabriel.pro.d3@gmail.com', $user->getEmail(), 'mail/reset_password.html.twig' , $params);
        return $this->getResultMessage($result);
    }

    /**
     * @param User $user
     * @param string $newPassword
     */
    public function resetPassword(User $user, string $newPassword) {
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $newPassword
            )
        );

        $user->clearResetToken();
        $this->entityManager->flush();
    }

    private function getResultMessage(int $result) : string
    {
        if ($result === 0)
            return $this->translator->trans('user.send_mail.error');
        return $this->translator->trans('user.send_mail.success');
    }
}