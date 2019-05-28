<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 14:20
 */

namespace App\Mapper;


use App\Entity\Dto\NewMessages\NewMessageItemDto;
use App\Entity\Dto\NewMessages\NewMessagesDto;
use App\Entity\Dto\NewMessages\UserDto;
use App\Entity\Message;
use App\Entity\User;

class NewMessagesMapper
{

    /**
     * @param Message[] $messages
     * @return NewMessagesDto
     */
    public function mapNewMessages($messages) : NewMessagesDto
    {
        $newMessages = new NewMessagesDto();
        $newMessages->setNewMessages($this->mapNewMessagesItems($messages));
        return $newMessages;
    }

    /**
     * @param Message[] $messages
     * @return array
     */
    private function mapNewMessagesItems($messages) : array
    {
        $messageItems = [];
        foreach ($messages as $message) {
            $messageItem = new NewMessageItemDto();
            $messageItem->setReceiver($this->mapUser($message->getReceiver()));
            $messageItem->setTransmitter($this->mapUser($message->getTransmitter()));
            $messageItem->setCreatedAt($message->getCreateAt());
            $messageItem->setContent($message->getContent());
            $messageItems[] = $messageItem;
        }
        return$messageItems;
    }

    private function mapUser(User $user) : UserDto
    {
        $userDto = new UserDto();
        $userDto->setId($user->getId());
        $userDto->setUsername($user->getUsername());
        $userDto->setAvatar($user->getAvatar());
        $userDto->setOnline($user->getOnline());
        return $userDto;
    }
}