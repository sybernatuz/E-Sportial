<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 05/01/2019
 * Time: 13:34
 */

namespace App\Services\layout;


use App\Enums\type\OrganizationTypeEnum;
use App\Repository\GameRepository;
use App\Repository\OrganizationRepository;

class FooterService
{
    private const GAMES_NUMBER = 5;
    private const SPONSORS_NUMBER = 5;

    private $gameRepository;
    private $organizationRepository;

    public function __construct(GameRepository $gameRepository, OrganizationRepository $organizationRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function process() {
        return [
            'footerGames' => $this->gameRepository->findByMostPopular(self::GAMES_NUMBER),
            'footerSponsors' => $this->organizationRepository->findByType(self::SPONSORS_NUMBER,OrganizationTypeEnum::SPONSOR)
        ];
    }
}