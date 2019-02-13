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

/**
 * Class GameRepositoryTest
 * @package App\Tests\project\repositories
 * @group Repository
 */
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
}