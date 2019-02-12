<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 12/02/2019
 * Time: 12:32
 */

namespace App\Entity\Search;



class GameSearch
{
    /**
     * @var string
     */
    private $word;

    /**
     * @return string
     */
    public function getWord(): ?string
    {
        return $this->word;
    }

    /**
     * @param string $word
     * @return GameSearch
     */
    public function setWord(string $word): GameSearch
    {
        $this->word = $word;
        return $this;
    }



}