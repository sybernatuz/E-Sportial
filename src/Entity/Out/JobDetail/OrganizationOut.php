<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 14/02/2019
 * Time: 16:51
 */

namespace App\Entity\Out\JobDetail;


class OrganizationOut
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $logoPath;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrganizationOut
     */
    public function setId(int $id): OrganizationOut
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return OrganizationOut
     */
    public function setName(string $name): OrganizationOut
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogoPath(): ?string
    {
        return $this->logoPath;
    }

    /**
     * @param string $logoPath
     * @return OrganizationOut
     */
    public function setLogoPath(string $logoPath): OrganizationOut
    {
        $this->logoPath = $logoPath;
        return $this;
    }




}