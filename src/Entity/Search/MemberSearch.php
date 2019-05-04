<?php

namespace App\Entity\Search;

use App\Entity\Country;

class MemberSearch
{
    /**
     * @var string
     */
    private $word;

    /**
     * @var Country
     */
    private $country;

    /**
     * @return Country
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }


    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(?string $word): self
    {
        $this->word = $word;

        return $this;
    }
}
