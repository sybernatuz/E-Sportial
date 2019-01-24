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
use App\Tests\setup\mock\UserMock;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
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
        $this->findByUsernameOrEmail(UserMock::USER_1_USERNAME);
        $this->findByUsernameOrEmail(UserMock::USER_1_EMAIL);
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
        $this->assertEquals(UserMock::USER_1_USERNAME, $user->getUsername());
        $this->assertEquals(UserMock::USER_1_ROLE, $user->getRoles());
    }

    public function testFindByUsernameOrEmailAdmin() : void
    {
        $this->findByUsernameOrEmailAdmin(UserMock::ADMIN_1_USERNAME);
        $this->findByUsernameOrEmailAdmin(UserMock::ADMIN_1_EMAIL);
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
        $this->assertEquals(UserMock::ADMIN_1_USERNAME, $user->getUsername());
        $this->assertEquals(UserMock::ADMIN_1_ROLE, $user->getRoles());
    }
}