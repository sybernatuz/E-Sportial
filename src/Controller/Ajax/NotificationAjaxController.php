<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 29/06/19
 * Time: 23:05
 */

namespace App\Controller\Ajax;


use App\Repository\NotificationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class MessageAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_notification_ajax_", path="/ajax/notification")
 */
class NotificationAjaxController extends AbstractController
{

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/get/notifications", name="get_notifications")
     * @param Security $security
     * @return JsonResponse
     */
    public function getNewMessages(Security $security) : JsonResponse
    {
        $notificationsCounter = count($this->notificationRepository->findBy(['user' => $security->getUser()]));
        return new JsonResponse($notificationsCounter);
    }

}