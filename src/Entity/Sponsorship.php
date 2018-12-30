<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SponsorshipRepository")
 */
class Sponsorship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="sponsored")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization", inversedBy="sponsorships")
     */
    private $sponsor;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    public function getSponsor()
    {
        return $this->sponsor;
    }

    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
        return $this;
    }
}
