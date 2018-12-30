<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="smallint")
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pro;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private $avatar;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users")
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Wall", mappedBy="user", cascade={"persist", "remove"})
     */
    private $wall;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Premium", mappedBy="user", orphanRemoval=true)
     */
    private $premium;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="user")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recrutment", mappedBy="user")
     */
    private $recrutments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subscription", mappedBy="user")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subscription", mappedBy="subscriber")
     */
    private $subscribed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Play", mappedBy="user")
     */
    private $plays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="receiver")
     */
    private $receivedMessages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="transmitter")
     */
    private $transmittedMessages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Party", mappedBy="users")
     */
    private $parties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Result", mappedBy="user")
     */
    private $results;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ranking", mappedBy="user")
     */
    private $rankings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Award", mappedBy="user")
     */
    private $awards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="user")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participant", mappedBy="user")
     */
    private $participants;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->premium = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->recrutments = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->subscribed = new ArrayCollection();
        $this->plays = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
        $this->transmittedMessages = new ArrayCollection();
        $this->parties = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->rankings = new ArrayCollection();
        $this->awards = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {}

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email) : self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname() : string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname) : self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname) : self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge() : int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return User
     */
    public function setAge($age) : self
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return bool
     */
    public function getPro() : bool
    {
        return $this->pro;
    }

    /**
     * @param bool $pro
     * @return User
     */
    public function setPro($pro) : self
    {
        $this->pro = $pro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * @param mixed $online
     * @return User
     */
    public function setOnline($online)
    {
        $this->online = $online;
        return $this;
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
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addUser($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeUser($this);
        }

        return $this;
    }

    public function getWall(): ?Wall
    {
        return $this->wall;
    }

    public function setWall(?Wall $wall): self
    {
        $this->wall = $wall;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $wall === null ? null : $this;
        if ($newUser !== $wall->getUser()) {
            $wall->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Premium[]
     */
    public function getPremium(): Collection
    {
        return $this->premium;
    }

    public function addPremium(Premium $premium): self
    {
        if (!$this->premium->contains($premium)) {
            $this->premium[] = $premium;
            $premium->setUser($this);
        }

        return $this;
    }

    public function removePremium(Premium $premium): self
    {
        if ($this->premium->contains($premium)) {
            $this->premium->removeElement($premium);
            // set the owning side to null (unless already changed)
            if ($premium->getUser() === $this) {
                $premium->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setUser($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getUser() === $this) {
                $job->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recrutment[]
     */
    public function getRecrutments(): Collection
    {
        return $this->recrutments;
    }

    public function addRecrutment(Recrutment $recrutment): self
    {
        if (!$this->recrutments->contains($recrutment)) {
            $this->recrutments[] = $recrutment;
            $recrutment->setUser($this);
        }

        return $this;
    }

    public function removeRecrutment(Recrutment $recrutment): self
    {
        if ($this->recrutments->contains($recrutment)) {
            $this->recrutments->removeElement($recrutment);
            // set the owning side to null (unless already changed)
            if ($recrutment->getUser() === $this) {
                $recrutment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setUser($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            // set the owning side to null (unless already changed)
            if ($subscription->getUser() === $this) {
                $subscription->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscribed(): Collection
    {
        return $this->subscribed;
    }

    public function addSubscribed(Subscription $subscribed): self
    {
        if (!$this->subscribed->contains($subscribed)) {
            $this->subscribed[] = $subscribed;
            $subscribed->setSubscriber($this);
        }

        return $this;
    }

    public function removeSubscribed(Subscription $subscribed): self
    {
        if ($this->subscribed->contains($subscribed)) {
            $this->subscribed->removeElement($subscribed);
            // set the owning side to null (unless already changed)
            if ($subscribed->getSubscriber() === $this) {
                $subscribed->setSubscriber(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Play[]
     */
    public function getPlays(): Collection
    {
        return $this->plays;
    }

    public function addPlay(Play $play): self
    {
        if (!$this->plays->contains($play)) {
            $this->plays[] = $play;
            $play->setUser($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->plays->contains($play)) {
            $this->plays->removeElement($play);
            // set the owning side to null (unless already changed)
            if ($play->getUser() === $this) {
                $play->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceivedMessages(): Collection
    {
        return $this->receivedMessages;
    }

    public function addReceivedMessage(Message $receivedMessage): self
    {
        if (!$this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages[] = $receivedMessage;
            $receivedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): self
    {
        if ($this->receivedMessages->contains($receivedMessage)) {
            $this->receivedMessages->removeElement($receivedMessage);
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getReceiver() === $this) {
                $receivedMessage->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getTransmittedMessages(): Collection
    {
        return $this->transmittedMessages;
    }

    public function addTransmittedMessage(Message $transmittedMessage): self
    {
        if (!$this->transmittedMessages->contains($transmittedMessage)) {
            $this->transmittedMessages[] = $transmittedMessage;
            $transmittedMessage->setTransmitter($this);
        }

        return $this;
    }

    public function removeTransmittedMessage(Message $transmittedMessage): self
    {
        if ($this->transmittedMessages->contains($transmittedMessage)) {
            $this->transmittedMessages->removeElement($transmittedMessage);
            // set the owning side to null (unless already changed)
            if ($transmittedMessage->getTransmitter() === $this) {
                $transmittedMessage->setTransmitter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Party[]
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties[] = $party;
            $party->addUser($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            $party->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Result[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setUser($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getUser() === $this) {
                $result->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ranking[]
     */
    public function getRankings(): Collection
    {
        return $this->rankings;
    }

    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings[] = $ranking;
            $ranking->setUser($this);
        }

        return $this;
    }

    public function removeRanking(Ranking $ranking): self
    {
        if ($this->rankings->contains($ranking)) {
            $this->rankings->removeElement($ranking);
            // set the owning side to null (unless already changed)
            if ($ranking->getUser() === $this) {
                $ranking->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Award[]
     */
    public function getAwards(): Collection
    {
        return $this->awards;
    }

    public function addAward(Award $award): self
    {
        if (!$this->awards->contains($award)) {
            $this->awards[] = $award;
            $award->setUser($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getUser() === $this) {
                $award->setUser(null);
            }
        }

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
            $file->setUser($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getUser() === $this) {
                $file->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setUser($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getUser() === $this) {
                $participant->setUser(null);
            }
        }

        return $this;
    }








}
