<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="messages")
     */
    private $parentMessage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="parentMessage")
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="receivedMessages")
     */
    private $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transmittedMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transmitter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wall", inversedBy="messages")
     */
    private $wall;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DiscussionGroup", inversedBy="messages")
     */
    private $discussionGroup;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="comments")
     */
    private $party;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="message")
     */
    private $files;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getParentMessage(): ?self
    {
        return $this->parentMessage;
    }

    public function setParentMessage(?self $parentMessage): self
    {
        $this->parentMessage = $parentMessage;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(self $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setParentMessage($this);
        }

        return $this;
    }

    public function removeMessage(self $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getParentMessage() === $this) {
                $message->setParentMessage(null);
            }
        }

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getTransmitter(): ?User
    {
        return $this->transmitter;
    }

    public function setTransmitter(?User $transmitter): self
    {
        $this->transmitter = $transmitter;

        return $this;
    }

    public function getWall(): ?Wall
    {
        return $this->wall;
    }

    public function setWall(?Wall $wall): self
    {
        $this->wall = $wall;

        return $this;
    }

    public function getDiscussionGroup()
    {
        return $this->discussionGroup;
    }

    public function setDiscussionGroup($discussionGroup)
    {
        $this->discussionGroup = $discussionGroup;
        return $this;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setMessage($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getMessage() === $this) {
                $file->setMessage(null);
            }
        }

        return $this;
    }
}
