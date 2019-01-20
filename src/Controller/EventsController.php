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
use App\Repository\GameRepository;
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
    private const FOOTER_GAMES_NUMBER = 5;

    private $gameRepository;
    private $eventRepository;

    public function __construct(GameRepository $gameRepository, EventRepository $eventRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route(name="index")
     */
    public function index()
    {
        return $this->render("pages/events.html.twig", [
            'eventTypes' => EventTypeEnum::getValues(),
            'lastEvents' => $this->eventRepository->findByLastDateAndType(self::EVENTS_NUMBER, EventTypeEnum::ALL),
            'pageNumber' => $this->eventRepository->getPaginationByType(self::EVENTS_NUMBER, EventTypeEnum::ALL),
            'footerGames' => $this->gameRepository->findByMostPopular(self::FOOTER_GAMES_NUMBER)
        ]);
    }
}