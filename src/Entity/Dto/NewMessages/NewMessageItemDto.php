<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 27/05/2019
 * Time: 12:45
 */

namespace App\Entity\Dto\NewMessages;


class NewMessageItemDto
{

    private $receiver;
    private $transmitter;
    private $content;
    private $createdAt;

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getTransmitter()
    {
        return $this->transmitter;
    }

    /**
     * @param mixed $transmitter
     */
    public function setTransmitter($transmitter): void
    {
        $this->transmitter = $transmitter;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }



}