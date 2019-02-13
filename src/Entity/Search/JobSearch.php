<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 13/02/2019
 * Time: 10:17
 */

namespace App\Entity\Search;


use App\Entity\Type;

class JobSearch
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
     * @return JobSearch
     */
    public function setWord(string $word): JobSearch
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
     * @return JobSearch
     */
    public function setLocation(string $location): JobSearch
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
     */
    public function setType(Type $type): void
    {
        $this->type = $type;
    }


}