<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 17:02
 */

namespace App\Entity\Out\JobDetail;


class UserOut
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserOut
     */
    public function setId(int $id): UserOut
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserOut
     */
    public function setUsername(string $username): UserOut
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return UserOut
     */
    public function setAvatar(string $avatar): UserOut
    {
        $this->avatar = $avatar;
        return $this;
    }




}