<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 11:09
 */

namespace App\Tests\project\repositories;


use App\Entity\Search\MemberSearch;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\setup\mock\CountryMock;
use App\Tests\setup\mock\UserMock;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class UserRepositoryTest
 * @package App\Tests\project\repositories
 * @group Repository
 */
class UserRepositoryTest extends AbstractRepositoryTest
{

    /**
     * @var UserRepository
     */
    protected $repository;

    protected function getClassName(): string
    {
        return User::class;
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
            $user = $this->repository->findByUsernameOrEmail($emailOrUsername);
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
            $user = $this->repository->findByUsernameOrEmailAdmin($emailOrUsername);
        } catch (NonUniqueResultException $e) {
            $this->fail('more than one result');
        }
        if ($user == null)
            $this->fail('No user found');
        $this->assertEquals(UserMock::$admin1->getUsername(), $user->getUsername());
        $this->assertEquals(UserMock::$admin1->getRoles(), $user->getRoles());
    }

    public function testFindBySearch1() : void
    {
        $search = (new MemberSearch)
            ->setWord("user");
        $users = (array) $this->repository->findBySearch($search)->getResult();
        $this->assertCount(1, $users);
        $this->assertEquals(UserMock::$user2->getUsername(), $users[0]['username']);
        $this->assertEquals(CountryMock::$country2->getName(), $users[0]['flagName']);
        $this->assertEquals(1, $users[0]['followers']);
    }
}