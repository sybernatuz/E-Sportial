<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 27/01/19
 * Time: 21:26
 */

namespace App\Services;



use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpKernel\KernelInterface;

class MailerService
{
    private $mailer;
    private $templating;
    private $assetManager;
    private $kernel;

    /**
     * MailerService constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param Packages $assetsManager
     * @param KernelInterface $kernel
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, Packages $assetsManager, KernelInterface $kernel)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->assetManager = $assetsManager;
        $this->kernel = $kernel;
    }

    /**
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $htmlTemplate
     * @param array $params
     * @param string|null $txtTemplate
     */
    public function sendMail(string $subject, string $from, string $to, string $htmlTemplate, array $params, string $txtTemplate = null) {
        $message = (new \Swift_Message($subject));

        $logo = ['logo' => $message->embed(\Swift_Image::fromPath( $this->kernel->getProjectDir() . '/public' . $this->assetManager->getUrl('build/images/logo.png')))];

        $message->setFrom($from)
                ->setTo($to);

        $this->addHtmlPart($message, $htmlTemplate, $params + $logo);

        if(isset($txtTemplate)) {
            $this->addTxtPart($message,$txtTemplate, $params);
        }

        $this->mailer->send($message);
    }

    /**
     * @param \Swift_Message $message
     * @param string $htmlTemplate
     * @param array $params
     */
    private function addHtmlPart(\Swift_Message $message, string $htmlTemplate, array $params) {
        $message->setBody(
            $this->templating->render(
                $htmlTemplate,
                $params
            ),
            'text/html'
        );
    }

    /**
     * @param \Swift_Message $message
     * @param string $txtTemplate
     * @param array $params
     */
    private function addTxtPart(\Swift_Message $message, string $txtTemplate, array $params) {
        $message->addPart(
            $this->templating->render(
                $txtTemplate,
                $params
            ),
            'text/plain'
        );
    }
}