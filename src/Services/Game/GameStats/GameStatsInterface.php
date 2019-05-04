<?php

namespace App\Services\Game\GameStats;

interface GameStatsInterface {
    public function getUserStats(string $apiUrl, string $pseudo);
    public function getStatsTemplate();
}