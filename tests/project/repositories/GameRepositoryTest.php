<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 24/01/2019
 * Time: 15:21
 */

namespace App\Tests\project\repositories;


use App\Entity\Game;
use App\Entity\Search\GameSearch;
use App\Repository\GameRepository;
use App\Tests\setup\mock\GameMock;

/**
 * Class GameRepositoryTest
 * @package App\Tests\project\repositories
 * @group Repository
 */
class GameRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @var GameRepository
     */
    protected $repository;

    protected function getClassName(): string
    {
        return Game::class;
    }

    public function testFindBySearch() : void
    {
        $search = (new GameSearch())->setWord("of");
        $games = (array) $this->repository->findBySearch($search)->getResult();
        $this->assertCount(3, $games);
        $gameNamesContainsOf = [
            GameMock::$game3->getName(),
            GameMock::$game4->getName(),
            GameMock::$game5->getName()
        ];
        foreach ($games as $game) {
            $this->assertTrue(in_array($game->getName(), $gameNamesContainsOf));
        }
    }
}