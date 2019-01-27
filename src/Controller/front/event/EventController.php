<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:49
 */

namespace App\Controller\front\event;


use App\Entity\Event;
use App\Services\layout\FooterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 * @Route(name="app_event_", path="/event")
 */
class EventController extends AbstractController
{

    private $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index", path="/{slug}")
     * @param Event $event
     * @return Response
     */
    public function index(Event $event) : Response
    {
        return $this->render('pages/front/event/event.html.twig', [
            'event' => $event
        ] + $this->footerService->process());
    }

}