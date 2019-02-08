<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:49
 */

namespace App\Controller\Front;


use App\Entity\Event;
use App\Enums\type\EventTypeEnum;
use App\Repository\EventRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 * @Route(name="app_event_")
 */
class EventController extends AbstractController
{

    private const EVENTS_NUMBER = 5;

    private $eventRepository;
    private $footerService;

    public function __construct(EventRepository $eventRepository, FooterService $footerService)
    {
        $this->eventRepository = $eventRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="one", path="/event/{slug}")
     * @param Event $event
     * @return Response
     */
    public function one(Event $event) : Response
    {
        return $this->render('pages/front/event/event.html.twig', [
            'event' => $event
        ] + $this->footerService->process());
    }

    /**
     * @Route(name="list", path="/events")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() : Response
    {
        return $this->render("pages/front/event/events.html.twig", [
                'eventTypes' => EventTypeEnum::getValues(),
                'lastEvents' => $this->eventRepository->findByLastDateAndType(self::EVENTS_NUMBER, EventTypeEnum::ALL),
                'pageNumber' => $this->eventRepository->getPaginationByType(self::EVENTS_NUMBER, EventTypeEnum::ALL)
            ] + $this->footerService->process());
    }
}