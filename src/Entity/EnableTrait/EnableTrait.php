<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 30/01/19
 * Time: 22:40
 */

namespace App\Entity\EnableTrait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait for "safe delete" feature.
 */
trait EnableTrait
{
    /**
     * @ORM\Column(type="boolean", options={"default": false}, nullable=false)
     * @var boolean delete.
     */
    protected $enable = true;

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     */
    public function setEnable(bool $enable): void
    {
        $this->enable = $enable;
    }

}