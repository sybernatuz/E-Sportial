<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 01/05/19
 * Time: 02:28
 */

namespace App\Services\Game;


use App\Entity\Game;
use App\Entity\User;
use App\Exceptions\DataConverter\DataConverterJsonDecodeException;
use App\Exceptions\GameAccount\GameAccountNotFoundException;
use App\Exceptions\GameStat\GameStatGameNotSupportedException;
use App\Repository\GameAccountRepository;
use App\Services\Api\FortniteApiCallerService;

class GameStatService
{
    const EXCEPTION_TEMPLATE_PATH = "modules/front/common/exception.html.twig";
    const STAT_TEMPLATE_PATH = "modules/front/user/show/tab/stat/";
    const TEMPLATE_SUFFIXE = "_stat_tab.html.twig";

    private $gameAccountRepository;
    private $fortniteApiCallerService;

    public function __construct(
        GameAccountRepository $gameAccountRepository,
        FortniteApiCallerService $fortniteApiCallerService
    )
    {
        $this->gameAccountRepository = $gameAccountRepository;
        $this->fortniteApiCallerService = $fortniteApiCallerService;
    }

    /**
     * @param Game $game
     * @param User $user
     * @return bool|mixed
     * @throws GameAccountNotFoundException
     * @throws GameStatGameNotSupportedException
     */
    public function getGameStats(Game $game, User $user) {
        $gameAccount = $this->gameAccountRepository
                            ->findByUserAndGame($user, $game);

        if(!$gameAccount) {
            throw new GameAccountNotFoundException($game);
        }

        $pseudo = $gameAccount->getPseudo();
        $apiUrl = $game->getApiUrl();
        $gameSlug = str_replace('-', '_', $game->getSlug());

        switch ($gameSlug) {
            case "fortnite":
                return $this->getUserFortniteStats($apiUrl, $pseudo);
                break;
            default:
                throw new GameStatGameNotSupportedException($game->getName());
                break;
        }
    }

    /**
     * @param string $gameSlug
     * @param bool $isException
     * @return string
     */
    public function getGameStatsTemplate(string $gameSlug, bool $isException = false) {
        if($isException) {
            return self::EXCEPTION_TEMPLATE_PATH;
        }
        return self::STAT_TEMPLATE_PATH . $gameSlug . self::TEMPLATE_SUFFIXE;
    }


    /**
     * @param string $apiUrl
     * @param string $pseudo
     * @return bool|mixed
     */
    private function getUserFortniteStats(string $apiUrl, string $pseudo) {
        $data = $this->fortniteApiCallerService->getUserStats($apiUrl, $pseudo);
        if(!$data) {
            throw new DataConverterJsonDecodeException();
        }
        return $data;
    }


}