<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 29/06/19
 * Time: 23:05
 */

namespace App\Controller\Ajax;


use App\Entity\Notification;
use App\Entity\Organization;
use App\Entity\Recruitment;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route(path="/get/notifications", name="get_notifications", options={"expose"=true})
     * @param Security $security
     * @return JsonResponse
     */
    public function getNewMessages(Security $security) : JsonResponse
    {
        $notificationsCounter = count($this->notificationRepository->findBy(['user' => $security->getUser()]));
        return new JsonResponse($notificationsCounter);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/accept/{organizationId}", name="accept_recruitment", options={"expose"=true})
     * @ParamConverter("notification", options={"id" = "id"})
     * @ParamConverter("organization", options={"id" = "organizationId"})
     * @param Notification $notification
     * @param Organization $organization
     * @param EntityManagerInterface $em
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function acceptRecruitment(Notification $notification, Organization $organization, EntityManagerInterface $em, Security $security)
    {
        $organization->addUser($security->getUser());
        $recruitment = new Recruitment();
        $recruitment->setUser($security->getUser());
        $recruitment->setOrganization($organization);
        $recruitment->setStartDate(new \DateTime());

        $em->remove($notification);
        $em->persist($recruitment);
        $em->flush();

        $recruitmentNotifications = $this->notificationRepository->findByTypeOrderByDate('recruitment', $security->getUser());
        return $this->render("modules/front/notification/index/recruitment.html.twig", [
                'recruitments' => $recruitmentNotifications ?? null,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/{id}/refuse", name="refuse_recruitment", options={"expose"=true})
     * @param Notification $notification
     * @param EntityManagerInterface $em
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function refuseRecruitment(Notification $notification, EntityManagerInterface $em, Security $security)
    {
        $em->remove($notification);
        $em->flush();

        $recruitmentNotifications = $this->notificationRepository->findByTypeOrderByDate('recruitment', $security->getUser());
        return $this->render("modules/front/notification/index/recruitment.html.twig", [
            'recruitments' => $recruitmentNotifications ?? null,
        ]);
    }

}