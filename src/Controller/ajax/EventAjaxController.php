<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 19/01/2019
 * Time: 21:14
 */

namespace App\Controller\ajax;


use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventAjaxController
 * @package App\Controller\ajax
 * @Route(name="app_event_ajax_", path="/ajax/event")
 */
class EventAjaxController extends AbstractController
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route(name="search", path="/search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request) : Response
    {
        $name = $request->get("name") != null ? $request->get("name") : '';
        $location = $request->get("location") != null ? $request->get("location") : '';
        $type = $request->get("type") != null ? $request->get("type") : '';
        $page = $request->get("page") != null ? $request->get("page") : 1;
        return $this->render("modules/front/events/lastEvents.html.twig", [
            'lastEvents' => $this->eventRepository->findByNameAndLocationAndTypeOrderByLastDate($name, $location, $type, 5, $page),
            'pageNumber' => $this->eventRepository->getPaginationByNameAndLocationAndType($name, $location, $type, 5),
            'activePage' => $page
        ]);
    }
}