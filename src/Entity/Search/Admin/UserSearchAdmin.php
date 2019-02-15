<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 15/02/2019
 * Time: 14:31
 */

namespace App\Entity\Search\Admin;


class UserSearchAdmin
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var int
     */
    private $age;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var boolean
     */
    private $online;

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserSearchAdmin
     */
    public function setUsername(string $username): UserSearchAdmin
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserSearchAdmin
     */
    public function setEmail(string $email): UserSearchAdmin
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserSearchAdmin
     */
    public function setLastName(string $lastName): UserSearchAdmin
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserSearchAdmin
     */
    public function setFirstName(string $firstName): UserSearchAdmin
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return UserSearchAdmin
     */
    public function setAge(int $age): UserSearchAdmin
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return UserSearchAdmin
     */
    public function setRoles(array $roles): UserSearchAdmin
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnline(): ?bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     * @return UserSearchAdmin
     */
    public function setOnline(bool $online): UserSearchAdmin
    {
        $this->online = $online;
        return $this;
    }


}