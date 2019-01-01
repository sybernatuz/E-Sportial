<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @Id()
     * @GeneratedValue()
     * @Column(type="integer")
     */
    private $id;

    /**
     * @Column(type="integer")
     */
    private $score;

    /**
     * @Column(type="float", nullable=true)
     */
    private $kills;

    /**
     * @Column(type="float", nullable=true)
     */
    private $deaths;

    /**
     * @Column(type="time", nullable=true)
     */
    private $duration;

    /**
     * @Column(type="datetime")
     */
    private $date;

    /**
     * @ManyToOne(targetEntity="App\Entity\Party", inversedBy="results")
     */
    private $party;

    /**
     * @ManyToOne(targetEntity="App\Entity\User", inversedBy="results")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="App\Entity\Roster", inversedBy="results")
     */
    private $roster;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getKills(): ?float
    {
        return $this->kills;
    }

    public function setKills(?float $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getDeaths(): ?float
    {
        return $this->deaths;
    }

    public function setDeaths(?float $deaths): self
    {
        $this->deaths = $deaths;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRoster(): ?Roster
    {
        return $this->roster;
    }

    public function setRoster(?Roster $roster): self
    {
        $this->roster = $roster;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
