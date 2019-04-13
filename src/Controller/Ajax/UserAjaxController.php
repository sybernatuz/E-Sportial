<?php

namespace App\Controller\Ajax;

use App\Entity\User;
use App\Handler\Member\SubscriptionHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_user_ajax_", path="/ajax/user")
 */
class UserAjaxController extends AbstractController
{
    private $serializer;
    private $subscriptionHandler;

    public function __construct(SerializerInterface $serializer, SubscriptionHandler $subscriptionHandler)
    {
        $this->serializer = $serializer;
        $this->subscriptionHandler = $subscriptionHandler;
    }

    /**
     * @Route(path="/{id}/subscribe", name="subscribe")
     * @param User $member
     * @return JsonResponse
     */
    public function subscribe(User $member) {
        $data = $this->subscriptionHandler->subscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }

    /**
     * @Route(path="/{id}/unsubscribe", name="unsubscribe")
     * @param User $member
     * @return JsonResponse
     */
    public function unsubscribe(User $member) {
        $data = $this->subscriptionHandler->unsubscribe($this->getUser(), $member);
        return new JsonResponse($this->serializer->serialize($data, 'json'));
    }
}
