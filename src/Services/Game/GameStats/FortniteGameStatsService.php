<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 04/05/19
 * Time: 15:48
 */

namespace App\Services\Game\GameStats;

use App\Exceptions\DataConverter\DataConverterJsonDecodeException;
use App\Services\Api\FortniteApiCallerService;

class FortniteGameStatsService implements GameStatsInterface
{
    const FORTNITE_STATS_TEMPLATE = 'modules/front/user/show/tab/stat/fortnite_stat_tab.html.twig';

    public function getUserStats(string $apiUrl, string $pseudo)
    {
        $data = FortniteApiCallerService::getUserStats($apiUrl, $pseudo);
        if(!$data) {
            throw new DataConverterJsonDecodeException();
        }
        return $data;
    }

    public function getStatsTemplate() : string
    {
        return self::FORTNITE_STATS_TEMPLATE;
    }
}