<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 29/06/19
 * Time: 22:50
 */

namespace App\Controller\Front;

use App\Repository\NotificationRepository;
use App\Services\layout\FooterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class MessageController
 * @package App\Controller\Front
 * @Route(name="app_notification_")
 */
class NotificationController extends AbstractController
{
    private $notificationRepository;
    private $footerService;

    /**
     * MessageController constructor.
     * @param NotificationRepository $notificationRepository
     * @param FooterService $footerService
     */
    public function __construct(NotificationRepository $notificationRepository, FooterService $footerService)
    {
        $this->notificationRepository = $notificationRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index", path="/notifications")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param Security $security
     * @return Response
     */
    public function index(Request $request, Security $security) : Response
    {
        $recruitmentNotifications = $this->notificationRepository->findBy(['user' => $security->getUser(), 'type' => 'recruitment']);

        return $this->render("pages/front/notification/index.html.twig", [
                'recruitments' => $recruitmentNotifications ?? null,
            ] + $this->footerService->process());
    }

}