<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 04/05/19
 * Time: 15:48
 */

namespace App\Services\Game\GameStats;

use App\Exceptions\DataConverter\DataConverterJsonDecodeException;
use App\Exceptions\GameStat\GameStatsFortniteDataNotFoundException;
use App\Exceptions\GameStat\GameStatsFortniteEpicNameUnknownException;
use App\Utils\DataConverterUtil;
use Unirest\Request;

class FortniteGameStatsService implements GameStatsInterface
{
    const USER_ID_ROUTE = '/users/id';
    const USER_STATS_ROUTE = '/users/public/br_stats_v2';
    const FORTNITE_STATS_TEMPLATE = 'modules/front/user/show/tab/stat/fortnite_stat_tab.html.twig';

    public function getUserStats(string $apiUrl, string $pseudo)
    {
        $uid = $this->getUid($apiUrl, $pseudo);

        if(!$uid) {
            throw new GameStatsFortniteEpicNameUnknownException($pseudo);
        }

        $headers = array('Accept' => 'application/json');
        $queryStats = array('user_id' => $uid, 'authorization' => '4635ae6ff6ddd205cc301e4ff3b81d24');
        $result = Request::get($apiUrl . self::USER_STATS_ROUTE, $headers, $queryStats)->body;

        if(isset($result->success) && !$result->success) {
            throw new GameStatsFortniteDataNotFoundException($pseudo);
        }

        $data = DataConverterUtil::stdClassToArray($result);
        if(!$data) {
            throw new DataConverterJsonDecodeException();
        }


        return $data;
    }

    /**
     * @return string
     */
    public function getStatsTemplate() : string
    {
        return self::FORTNITE_STATS_TEMPLATE;
    }

    /**
     * @param string $apiUrl
     * @param string $pseudo
     * @return string | boolean
     */
    private function getUid(string $apiUrl, string $pseudo) {
        $headers = array('Accept' => 'application/json');

        $queryUid = array('username' => $pseudo, 'authorization' => '4635ae6ff6ddd205cc301e4ff3b81d24');
        $result = Request::get($apiUrl . self::USER_ID_ROUTE, $headers, $queryUid)->body;

        if(isset($result->success) && !$result->success) {
            return false;
        }

        return $result->uid;
    }
}