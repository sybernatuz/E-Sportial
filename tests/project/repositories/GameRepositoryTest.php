<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:21
 */

namespace App\Tests\project\repositories;


use App\Entity\Game;
use App\Repository\GameRepository;
use App\Tests\setup\mock\AbstractMockInitializerTest;
use App\Tests\setup\mock\GameMock;

class GameRepositoryTest extends AbstractMockInitializerTest
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    protected function setUp() : void
    {
        $this->gameRepository = self::bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Game::class);
    }

    public function testFindByOrderByNameAsc(): void
    {
        $games = $this->gameRepository->findByOrderByNameAsc(3);
        $this->assertCount(3, $games);
        $this->assertEquals(GameMock::$game3->getName(), $games[0]->getName());
        $this->assertEquals(GameMock::$game2->getName(), $games[1]->getName());
        $this->assertEquals(GameMock::$game1->getName(), $games[2]->getName());
    }

    public function testFindByName() : void
    {
        $games = $this->gameRepository->findByName('of', 5);
        $this->assertCount(3, $games);
        foreach ($games as $game) {
            $this->assertTrue(in_array($game->getName(), [
                GameMock::$game3->getName(),
                GameMock::$game4->getName(),
                GameMock::$game5->getName()
            ]));
        }
    }

    public function testPaginationForFindByName() : void
    {
        $gamesPage1 = $this->gameRepository->findByName('of', 1, 1);
        $this->assertCount(1, $gamesPage1);
        $gamesPage2 = $this->gameRepository->findByName('of', 1, 2);
        $this->assertCount(1, $gamesPage2);
        $gamesPage3 = $this->gameRepository->findByName('of', 1, 3);
        $this->assertCount(1, $gamesPage3);
        $games = (array) array_merge($gamesPage1, $gamesPage2, $gamesPage3);
        $this->assertCount(3, $games);
        foreach ($games as $game) {
            $this->assertTrue(in_array($game->getName(), [
                GameMock::$game3->getName(),
                GameMock::$game4->getName(),
                GameMock::$game5->getName()
            ]));
        }
    }

    public function testGetPaginationByName() : void
    {
        $pageNumber = $this->gameRepository->getPaginationByName('of', 1);
        $this->assertEquals(3, $pageNumber);
        $pageNumber = $this->gameRepository->getPaginationByName('of', 3);
        $this->assertEquals(1, $pageNumber);
    }

    public function testGetPagination() : void
    {
        $pageNumber = $this->gameRepository->getPagination(1);
        $this->assertEquals(5, $pageNumber);
        $pageNumber = $this->gameRepository->getPagination(2);
        $this->assertEquals(2, $pageNumber);
        $pageNumber = $this->gameRepository->getPagination(5);
        $this->assertEquals(1, $pageNumber);
    }
}