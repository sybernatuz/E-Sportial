<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 26/01/2019
 * Time: 15:49
 */

namespace App\Controller\Front;


use App\Entity\Event;
use App\Entity\Search\EventSearch;
use App\Entity\User;
use App\Form\Front\Event\NewFormType;
use App\Form\Search\EventSearchType;
use App\Repository\EventRepository;
use App\Services\layout\FooterService;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route(path="/event/new", name="new")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request) {
        $event = new Event();
        $form = $this->createForm(NewFormType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $organization = $this->getUser()->getOrganization();
            $event->setOrganization($organization);
            $this->getDoctrine()->getManager()->persist($event);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Event created');
            return $this->redirectToRoute('app_team_show', ['slug' => $organization->getSlug()]);
        }
        return $this->render('pages/front/event/new.html.twig', [
                'newForm' => $form->createView()
            ] + $this->footerService->process());
    }

    /**
     * @Route(name="show", path="/event/{slug}")
     * @param Event $event
     * @return Response
     */
    public function show(Event $event) : Response
    {
        if($this->isGranted('ROLE_USER')) {
            $user = $this->getUser();
            if ($user instanceof User) {
                $eventJoined = $this->eventRepository->findByParticipant($user, $event->getId());
            }
            $isJoined = isset($eventJoined) && $eventJoined != null ? true : false;
        }
        return $this->render('pages/front/event/show.html.twig', [
            'isJoined' => $isJoined ?? false,
            'event' => $event
        ] + $this->footerService->process());
    }

    /**
     * @Route(name="list", path="/events")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function list(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new EventSearch();
        $searchForm = $this->createForm(EventSearchType::class, $search);
        $searchForm->handleRequest($request);

        $events = $paginator->paginate(
            $this->eventRepository->findBySearchOrderByLastDate($search),
            $request->query->getInt('page', 1),
            self::EVENTS_NUMBER
        );

        return $this->render("pages/front/event/list.html.twig", [
                'lastEvents' => $events,
                'searchForm' => $searchForm->createView()
            ] + $this->footerService->process());
    }


}