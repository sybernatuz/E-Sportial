<?php
/**
 * Created by PhpStorm.
 * User: d3one
 * Date: 01/05/19
 * Time: 15:06
 */

namespace App\Services\Api;

use Unirest\Request;

class LeagueOfLegendsApiCallerService
{
    const USER_ID_ROUTE = '/users/id';
    const USER_STATS_ROUTE = '/users/public/br_stats_v2';

    /**
     * Call API https://fortniteapi.com/
     * @param string $apiUrl
     * @param string $pseudo
     * @return mixed
     */
    public function callApi(string $apiUrl, string $pseudo) {
        $headers = array('Accept' => 'application/json');

        $queryUid = array('username' => $pseudo);
        $uid = Request::get($apiUrl . self::USER_ID_ROUTE, $headers, $queryUid)->body->uid;

        $queryStats = array('user_id' => $uid);
        $stats = Request::get($apiUrl . self::USER_STATS_ROUTE, $headers, $queryStats)->body;
        return $stats;
    }
}