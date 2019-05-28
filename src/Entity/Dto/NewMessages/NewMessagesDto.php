<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 12:42
 */

namespace App\Entity\Dto\NewMessages;


class NewMessagesDto
{
    private $newMessages;

    /**
     * @return mixed
     */
    public function getNewMessages()
    {
        return $this->newMessages;
    }

    /**
     * @param mixed $newMessages
     */
    public function setNewMessages($newMessages): void
    {
        $this->newMessages = $newMessages;
    }


}