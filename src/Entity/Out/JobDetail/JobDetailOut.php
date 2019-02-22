<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 16:49
 */

namespace App\Entity\Out\JobDetail;


class JobDetailOut
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $location;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var float
     */
    private $salary;

    /**
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @var bool
     */
    private $isApplied;

    /**
     * @var OrganizationOut
     */
    private $organization;

    /**
     * @var UserOut
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return JobDetailOut
     */
    public function setId(int $id): JobDetailOut
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return JobDetailOut
     */
    public function setDescription(string $description): JobDetailOut
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return JobDetailOut
     */
    public function setTitle(string $title): JobDetailOut
    {
        $this->title = $title;
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
     * @return JobDetailOut
     */
    public function setLocation(string $location): JobDetailOut
    {
        $this->location = $location;
        return $this;
    }



    /**
     * @return OrganizationOut
     */
    public function getOrganization(): ?OrganizationOut
    {
        return $this->organization;
    }

    /**
     * @param OrganizationOut $organization
     * @return JobDetailOut
     */
    public function setOrganization(OrganizationOut $organization): JobDetailOut
    {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return UserOut
     */
    public function getUser(): ?UserOut
    {
        return $this->user;
    }

    /**
     * @param UserOut $user
     * @return JobDetailOut
     */
    public function setUser(UserOut $user): JobDetailOut
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return JobDetailOut
     */
    public function setDuration(int $duration): JobDetailOut
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return float
     */
    public function getSalary(): ?float
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     * @return JobDetailOut
     */
    public function setSalary(float $salary): JobDetailOut
    {
        $this->salary = $salary;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return JobDetailOut
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): JobDetailOut
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isApplied(): bool
    {
        return $this->isApplied;
    }

    /**
     * @param bool $isApplied
     * @return JobDetailOut
     */
    public function setIsApplied(bool $isApplied): JobDetailOut
    {
        $this->isApplied = $isApplied;
        return $this;
    }









}