<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 14:02
 */

namespace App\Entity\Search;


use App\Entity\Type;

class EventSearch
{
    /**
     * @var string
     */
    private $word;

    /**
     * @var string
     */
    private $location;

    /**
     * @var Type
     */
    private $type;

    /**
     * @return string
     */
    public function getWord(): ?string
    {
        return $this->word;
    }

    /**
     * @param string $word
     * @return EventSearch
     */
    public function setWord(string $word): EventSearch
    {
        $this->word = $word;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return EventSearch
     */
    public function setLocation(string $location): EventSearch
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Type
     */
    public function getType(): ?Type
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return EventSearch
     */
    public function setType(Type $type): EventSearch
    {
        $this->type = $type;
        return $this;
    }


}