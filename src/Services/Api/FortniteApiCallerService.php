<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 01/05/19
 * Time: 14:33
 */

namespace App\Services\Api;

use App\Exceptions\GameStat\GameStatFortniteDataNotFoundException;
use App\Exceptions\GameStat\GameStatFortniteEpicNameUnknownException;
use Unirest\Request;
use App\Utils\DataConverterUtil;

class FortniteApiCallerService
{
    const USER_ID_ROUTE = '/users/id';
    const USER_STATS_ROUTE = '/users/public/br_stats_v2';

    /**
     * @param string $apiUrl
     * @param string $pseudo
     * @return mixed | boolean
     * @throws GameStatFortniteEpicNameUnknownException
     * @throws GameStatFortniteDataNotFoundException
     */
    public static function getUserStats(string $apiUrl, string $pseudo) {
        $uid = self::getUid($apiUrl, $pseudo);
        if(!$uid) {
            throw new GameStatFortniteEpicNameUnknownException($pseudo);
        }

        $headers = array('Accept' => 'application/json');
        $queryStats = array('user_id' => $uid);
        $result = Request::get($apiUrl . self::USER_STATS_ROUTE, $headers, $queryStats)->body;

        if(property_exists($result, 'success') && !$result->success) {
            throw new GameStatFortniteDataNotFoundException($pseudo);
        }

        return DataConverterUtil::stdClassToArray($result);
    }

    /**
     * @param string $apiUrl
     * @param string $pseudo
     * @return string | boolean
     */
    private static function getUid(string $apiUrl, string $pseudo) {
        $headers = array('Accept' => 'application/json');

        $queryUid = array('username' => $pseudo);
        $result = Request::get($apiUrl . self::USER_ID_ROUTE, $headers, $queryUid)->body;

        if(property_exists($result, 'success') && !$result->success) {
            return false;
        }

        return $result->uid;
    }
}