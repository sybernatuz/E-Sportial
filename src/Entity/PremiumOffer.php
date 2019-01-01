<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PremiumOfferRepository")
 */
class PremiumOffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Premium", mappedBy="premiumOffer")
     */
    private $premium;

    public function __construct()
    {
        $this->premium = new ArrayCollection();
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $premium->setPremiumOffer($this);
        }

        return $this;
    }

    public function removePremium(Premium $premium): self
    {
        if ($this->premium->contains($premium)) {
            $this->premium->removeElement($premium);
            // set the owning side to null (unless already changed)
            if ($premium->getPremiumOffer() === $this) {
                $premium->setPremiumOffer(null);
            }
        }

        return $this;
    }
}
