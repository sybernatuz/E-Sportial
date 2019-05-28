<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 11:19
 */

namespace App\Controller\Ajax;


use App\Mapper\NewMessagesMapper;
use App\Repository\MessageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MessageAjaxController
 * @package App\Controller\Ajax
 * @Route(name="app_message_ajax_", path="/ajax/message")
 */
class MessageAjaxController extends AbstractController
{
    const MESSAGES_NUMBER = 30;

    private $serializer;
    private $messageRepository;

    public function __construct(SerializerInterface $serializer, MessageRepository $messageRepository)
    {
        $this->serializer = $serializer;
        $this->messageRepository = $messageRepository;
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route(path="/get/new-messages", name="get_new_messages")
     * @param NewMessagesMapper $mapper
     * @return JsonResponse
     */
    public function getNewMessages(NewMessagesMapper $mapper) : JsonResponse
    {
        $unreadMessages = $this->messageRepository->findByReceiverAndNotRead($this->getUser());
        $newMessagesDto = $mapper->mapNewMessages($unreadMessages);
        return new JsonResponse($this->serializer->normalize($newMessagesDto, 'json'));
    }

    /**
     * @Route(name="get_pagination", path="/pagination")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(PaginatorInterface $paginator, Request $request) : Response
    {
        $messages = $paginator->paginate(
            $this->messageRepository->findByReceiverOrTransmitterOrderByDate($this->getUser()),
            $request->query->getInt('page', 1),
            self::MESSAGES_NUMBER
        );
        return $this->render("modules/front/message/list/messages.html.twig", [
            "messages" => $messages
        ]);
    }
}