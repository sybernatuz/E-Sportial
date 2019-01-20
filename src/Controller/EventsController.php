<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 19/01/2019
 * Time: 19:10
 */

namespace App\Controller;


use App\Enums\type\EventTypeEnum;
use App\Repository\EventRepository;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventsController
 * @package App\Controller
 * @Route(name="app_events_", path="/events")
 */
class EventsController extends AbstractController
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
     * @Route(name="index")
     */
    public function index()
    {
        return $this->render("pages/events.html.twig", [
            'eventTypes' => EventTypeEnum::getValues(),
            'lastEvents' => $this->eventRepository->findByLastDateAndType(self::EVENTS_NUMBER, EventTypeEnum::ALL),
            'pageNumber' => $this->eventRepository->getPaginationByType(self::EVENTS_NUMBER, EventTypeEnum::ALL)
        ] + $this->footerService->process());
    }
}