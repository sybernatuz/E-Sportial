<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultRepository")
 */
class Result
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $kills;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $deaths;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Party", inversedBy="results")
     */
    private $party;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="results")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Roster", inversedBy="results")
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
}
