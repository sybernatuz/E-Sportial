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
    public function getUserStats(string $apiUrl, string $pseudo) {
        $uid = $this->getUid($apiUrl, $pseudo);
        if(!$uid) {
            throw new GameStatFortniteEpicNameUnknownException($pseudo);
        }

        $headers = array('Accept' => 'application/json');
        $queryStats = array('user_id' => $uid);
        $result = Request::get($apiUrl . self::USER_STATS_ROUTE, $headers, $queryStats)->body;

        if(property_exists($result, 'success') && !$result->success) {
            throw new GameStatFortniteDataNotFoundException($pseudo);
        }

        return DataConverterUtil::StdClassToArray($result);
    }

    /**
     * @param string $apiUrl
     * @param string $pseudo
     * @return string | boolean
     */
    private function getUid(string $apiUrl, string $pseudo) : string {
        $headers = array('Accept' => 'application/json');

        $queryUid = array('username' => $pseudo);
        $result = Request::get($apiUrl . self::USER_ID_ROUTE, $headers, $queryUid)->body;

        if(property_exists($result, 'success') && !$result->success) {
            return false;
        }

        return Request::get($apiUrl . self::USER_ID_ROUTE, $headers, $queryUid)->body->uid;
    }
}