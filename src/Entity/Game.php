<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(type="string", length=255)
     */
    private $posterPath;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apiUrl;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Roster", mappedBy="game")
     */
    private $rosters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Play", mappedBy="game")
     */
    private $plays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Party", mappedBy="game")
     */
    private $parties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="game")
     */
    private $jobs;

    public function __construct()
    {
        $this->rosters = new ArrayCollection();
        $this->plays = new ArrayCollection();
        $this->parties = new ArrayCollection();
        $this->jobs = new ArrayCollection();
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

    public function getPosterPath() : string
    {
        return $this->posterPath;
    }

    public function setPosterPath($posterPath) : self
    {
        $this->posterPath = $posterPath;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getApiUrl(): ?string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(?string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

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
            $roster->setGame($this);
        }

        return $this;
    }

    public function removeRoster(Roster $roster): self
    {
        if ($this->rosters->contains($roster)) {
            $this->rosters->removeElement($roster);
            // set the owning side to null (unless already changed)
            if ($roster->getGame() === $this) {
                $roster->setGame(null);
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
            $play->setGame($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->plays->contains($play)) {
            $this->plays->removeElement($play);
            // set the owning side to null (unless already changed)
            if ($play->getGame() === $this) {
                $play->setGame(null);
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
            $party->setGame($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            // set the owning side to null (unless already changed)
            if ($party->getGame() === $this) {
                $party->setGame(null);
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
            $job->setGame($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getGame() === $this) {
                $job->setGame(null);
            }
        }

        return $this;
    }
}
