<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 06/01/2019
 * Time: 17:29
 */

namespace App\Services\home;


use App\Enums\type\EventTypeEnum;
use App\Objects\DataHolder;
use App\Repository\EventRepository;

class LastEventsService
{
    private const LAST_EVENTS_NUMBER = 3;

    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function process(DataHolder $finalDataHolder)
    {
        $lastEvents = $this->eventRepository->findByLastDateAndType(self::LAST_EVENTS_NUMBER, EventTypeEnum::TOURNAMENT);
        $finalDataHolder->put("lastEvents", $lastEvents);
    }


}