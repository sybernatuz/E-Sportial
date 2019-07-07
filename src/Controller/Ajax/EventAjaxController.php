<?php


namespace App\Controller\Ajax;


use App\Entity\Event;
use App\Entity\Participant;
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

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route(name="join", path="/join/{id}")
     * @IsGranted("ROLE_USER")
     * @param Event $event
     * @return Response
     */
    public function join(Event $event)
    {
        $participant = (new Participant())
            ->setUser($this->getUser())
            ->setEvent($event);
        $event->addParticipant($participant);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse($this->serializer->normalize(true, 'json'));
    }

}