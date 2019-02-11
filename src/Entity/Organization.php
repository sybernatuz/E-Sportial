<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoPath;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verify;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="organizations")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="organizations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="organization")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sponsorship", mappedBy="sponsor")
     */
    private $sponsorships;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sponsorship", mappedBy="team")
     */
    private $sponsored;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Wall", mappedBy="organization", cascade={"persist", "remove"})
     */
    private $wall;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="organization")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recruitment", mappedBy="organization")
     */
    private $recruitments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Subscription", mappedBy="organization")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Roster", mappedBy="organization")
     */
    private $rosters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Award", mappedBy="organization")
     */
    private $awards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="organization")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="organization", cascade={"persist"})
     */
    private $users;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->sponsorships = new ArrayCollection();
        $this->sponsored = new ArrayCollection();
        $this->jobs = new ArrayCollection();
        $this->recruitments = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->rosters = new ArrayCollection();
        $this->awards = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Organization
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogoPath(): ?string
    {
        return $this->logoPath;
    }

    public function setLogoPath(string $logoPath): self
    {
        $this->logoPath = $logoPath;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVerify(): ?bool
    {
        return $this->verify;
    }

    public function setVerify(bool $verify): self
    {
        $this->verify = $verify;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setOrganization($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getOrganization() === $this) {
                $event->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sponsorship[]
     */
    public function getSponsorships(): Collection
    {
        return $this->sponsorships;
    }

    public function addSponsorships(Sponsorship $sponsorship): self
    {
        if (!$this->sponsorships->contains($sponsorship)) {
            $this->sponsorships[] = $sponsorship;
            $sponsorship->setSponsor($this);
        }

        return $this;
    }

    public function removeSponsorships(Sponsorship $sponsorship): self
    {
        if ($this->sponsorships->contains($sponsorship)) {
            $this->sponsorships->removeElement($sponsorship);
            // set the owning side to null (unless already changed)
            if ($sponsorship->getSponsor() === $this) {
                $sponsorship->setSponsor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sponsorship[]
     */
    public function getSponsored(): Collection
    {
        return $this->sponsored;
    }

    public function addSponsored(Sponsorship $sponsorship): self
    {
        if (!$this->sponsored->contains($sponsorship)) {
            $this->sponsored[] = $sponsorship;
            $sponsorship->setTeam($this);
        }

        return $this;
    }

    public function removeSponsored(Sponsorship $sponsorship): self
    {
        if ($this->sponsored->contains($sponsorship)) {
            $this->sponsored->removeElement($sponsorship);
            // set the owning side to null (unless already changed)
            if ($sponsorship->getTeam() === $this) {
                $sponsorship->setTeam(null);
            }
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
        $newOrganization = $wall === null ? null : $this;
        if ($newOrganization !== $wall->getOrganization()) {
            $wall->setOrganization($newOrganization);
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
            $job->setOrganization($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getOrganization() === $this) {
                $job->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Recruitment[]
     */
    public function getRecruitments(): Collection
    {
        return $this->recruitments;
    }

    public function addRecruitment(Recruitment $recruitment): self
    {
        if (!$this->recruitments->contains($recruitment)) {
            $this->recruitments[] = $recruitment;
            $recruitment->setOrganization($this);
        }

        return $this;
    }

    public function removeRecruitment(Recruitment $recruitment): self
    {
        if ($this->recruitments->contains($recruitment)) {
            $this->recruitments->removeElement($recruitment);
            // set the owning side to null (unless already changed)
            if ($recruitment->getOrganization() === $this) {
                $recruitment->setOrganization(null);
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
            $subscription->setOrganization($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->contains($subscription)) {
            $this->subscriptions->removeElement($subscription);
            // set the owning side to null (unless already changed)
            if ($subscription->getOrganization() === $this) {
                $subscription->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Roster[]
     */
    public function getRosters(): Collection
    {
        return $this->rosters;
    }

    public function addRoster(Roster $roster): self
    {
        if (!$this->rosters->contains($roster)) {
            $this->rosters[] = $roster;
            $roster->setOrganization($this);
        }

        return $this;
    }

    public function removeRoster(Roster $roster): self
    {
        if ($this->rosters->contains($roster)) {
            $this->rosters->removeElement($roster);
            // set the owning side to null (unless already changed)
            if ($roster->getOrganization() === $this) {
                $roster->setOrganization(null);
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
            $award->setOrganization($this);
        }

        return $this;
    }

    public function removeAward(Award $award): self
    {
        if ($this->awards->contains($award)) {
            $this->awards->removeElement($award);
            // set the owning side to null (unless already changed)
            if ($award->getOrganization() === $this) {
                $award->setOrganization(null);
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
            $file->setOrganization($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getOrganization() === $this) {
                $file->setOrganization(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOrganization($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getOrganization() === $this) {
                $user->setOrganization(null);
            }
        }

        return $this;
    }

}
