<?php


namespace App\Controller\Ajax;


use App\Entity\Event;
use App\Entity\Participant;
use App\Entity\User;
use App\Repository\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MessageAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_event_ajax_", path="/ajax/event")
 */
class EventAjaxController extends AbstractController
{

    private $serializer;
    private $eventRepository;

    public function __construct(SerializerInterface $serializer, EventRepository $eventRepository)
    {
        $this->serializer = $serializer;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route(name="join", path="/join/{id}")
     * @IsGranted("ROLE_USER")
     * @param Event $event
     * @return Response
     */
    public function join(Event $event)
    {
        $user = $this->getUser();
        if ($user instanceof User) {
            $eventJoined = $this->eventRepository->findByParticipant($user, $event->getId());
        }
        $isJoined = isset($eventJoined) && $eventJoined != null ? true : false;
        if ($isJoined)
            return new JsonResponse($this->serializer->normalize(true, 'json'));
        
        $participant = (new Participant())
            ->setUser($this->getUser())
            ->setEvent($event);
        $event->addParticipant($participant);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($this->serializer->normalize(true, 'json'));
    }

}