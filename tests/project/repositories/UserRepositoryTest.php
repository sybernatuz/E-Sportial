<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 11:09
 */

namespace App\Tests\project\repositories;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\setup\mock\AbstractMockInitializerTest;
use App\Tests\setup\mock\UserMock;
use Doctrine\ORM\NonUniqueResultException;

class UserRepositoryTest extends AbstractMockInitializerTest
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    protected function setUp() : void
    {
        $this->userRepository = self::bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(User::class);
    }

    public function testFindByUsernameOrEmail() : void
    {
        $this->findByUsernameOrEmail(UserMock::$user1->getUsername());
        $this->findByUsernameOrEmail(UserMock::$user1->getEmail());
    }
    private function findByUsernameOrEmail(string $emailOrUsername) : void
    {
        $user = null;
        try {
            $user = $this->userRepository->findByUsernameOrEmail($emailOrUsername);
        } catch (NonUniqueResultException $e) {
            $this->fail('more than one result');
        }
        if ($user == null)
            $this->fail('No user found');
        $this->assertEquals(UserMock::$user1->getUsername(), $user->getUsername());
        $this->assertEquals(UserMock::$user1->getRoles(), $user->getRoles());
    }

    public function testFindByUsernameOrEmailAdmin() : void
    {
        $this->findByUsernameOrEmailAdmin(UserMock::$admin1->getUsername());
        $this->findByUsernameOrEmailAdmin(UserMock::$admin1->getEmail());
    }

    private function findByUsernameOrEmailAdmin(string $emailOrUsername) : void
    {
        $user = null;
        try {
            $user = $this->userRepository->findByUsernameOrEmailAdmin($emailOrUsername);
        } catch (NonUniqueResultException $e) {
            $this->fail('more than one result');
        }
        if ($user == null)
            $this->fail('No user found');
        $this->assertEquals(UserMock::$admin1->getUsername(), $user->getUsername());
        $this->assertEquals(UserMock::$admin1->getRoles(), $user->getRoles());
    }
}