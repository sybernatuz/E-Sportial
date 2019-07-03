<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 02/07/19
 * Time: 19:31
 */


namespace App\Entity\Dto\Roster;

use App\Validator\Constraints as CustomAssert;

/**
 * Class AddUserToRosterDto
 * @package App\Entity\Dto\Roster
 * @CustomAssert\UserExist
 */
class AddUserToRosterDto
{
    private $username;
    private $roster;
    private $team;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getRoster()
    {
        return $this->roster;
    }

    /**
     * @param mixed $roster
     */
    public function setRoster($roster): void
    {
        $this->roster = $roster;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param mixed $team
     */
    public function setTeam($team): void
    {
        $this->team = $team;
    }





}