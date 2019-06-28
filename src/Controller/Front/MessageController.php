<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 15:01
 */

namespace App\Controller\Front;


use App\Entity\DiscussionGroup;
use App\Entity\Message;
use App\Form\Front\Message\AddDiscussionGroupFormType;
use App\Form\Front\Message\AddMessageFormType;
use App\Repository\DiscussionGroupRepository;
use App\Repository\MessageRepository;
use App\Services\layout\FooterService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 * @package App\Controller\Front
 * @Route(name="app_message_")
 */
class MessageController extends AbstractController
{
    const MESSAGES_NUMBER = 30;

    private $messageRepository;
    private $footerService;

    /**
     * MessageController constructor.
     * @param MessageRepository $messageRepository
     * @param FooterService $footerService
     */
    public function __construct(MessageRepository $messageRepository, FooterService $footerService)
    {
        $this->messageRepository = $messageRepository;
        $this->footerService = $footerService;
    }

    /**
     * @Route(name="index", path="/messages")
     * @IsGranted("ROLE_USER")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param DiscussionGroupRepository $discussionGroupRepository
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request, DiscussionGroupRepository $discussionGroupRepository) : Response
    {
        $discussions = $paginator->paginate(
            $discussionGroupRepository->findByUser($this->getUser()),
            $request->query->getInt('page', 1),
            self::MESSAGES_NUMBER
        );

        return $this->render("pages/front/message/index.html.twig", [
                'discussions' => $discussions,
                'discussion' => $discussions[0] ?? null
            ] + $this->footerService->process());
    }

}