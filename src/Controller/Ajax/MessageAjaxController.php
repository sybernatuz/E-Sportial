<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 11:19
 */

namespace App\Controller\Ajax;


use App\Entity\DiscussionGroup;
use App\Entity\Message;
use App\Form\Front\Message\AddDiscussionGroupFormType;
use App\Form\Front\Message\AddMessageFormType;
use App\Mapper\NewMessagesMapper;
use App\Repository\MessageRepository;
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
     * @Route(name="get_discussion", path="/get/discussion/{id}")
     * @IsGranted("ROLE_USER")
     * @param DiscussionGroup $discussionGroup
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function discussion(DiscussionGroup $discussionGroup) : Response
    {
        $discussionGroup->getMessages()->forAll(function (int $key, Message $message) {$message->setIsRead(true);});
        $this->getDoctrine()->getManager()->flush();
        return $this->render("modules/front/message/index/discussion.html.twig", [
            "discussion" => $discussionGroup
        ]);
    }

//    /**
//     * @Route(name="insert", path="/insert")
//     * @IsGranted("ROLE_USER")
//     * @param DiscussionGroupRepository $discussionGroupRepository
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function insert(DiscussionGroupRepository $discussionGroupRepository, Request $request)
//    {
//        $discussion = $discussionGroupRepository->find($request->get('discussion'));
//        $message = new Message();
//        $message->setContent($request->get('content'));
//        $message->setDiscussionGroup($discussion);
//        $message->setTransmitter($this->getUser());
//        $message->setReceiver($discussion->getUsers()[0] ?? null);
//        $message->setIsRead(false);
//        $manager = $this->getDoctrine()->getManager();
//        $manager->persist($message);
//        $manager->flush();
//        return new JsonResponse($this->serializer->normalize(true, 'json'));
//    }

    /**
     * @Route(name="get_new_form", path="/get/new-form")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function getNewForm(Request $request)
    {
        $discussionGroup = new DiscussionGroup();
//        $gameAccount->setGamer($user);

        $addMessageForm = $this->createForm(AddDiscussionGroupFormType::class, $discussionGroup);
        $addMessageForm->handleRequest($request);

        if($addMessageForm->isSubmitted() && $addMessageForm->isValid()) {
            $this->getDoctrine()->getManager()->persist($discussionGroup);
            $this->getDoctrine()->getManager()->flush();
            return $this->render('modules/front/message/index/discussion.html.twig', [
                "discussion" => $discussionGroup
            ]);
        }

        return $this->render('modules/front/message/index/form.html.twig', [
            "form" => $addMessageForm->createView()
        ]);
    }
}