<?php


namespace App\DataFixtures\demo;


use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Asset\Packages;

class GameFixturesDemo extends Fixture implements FixtureGroupInterface
{
    private $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function load(ObjectManager $manager)
    {
        $fortnite = (new Game())
            ->setApiUrl("https://fortnite-api.theapinetwork.com/")
            ->setDescription("Fortnite est un jeu en ligne développé par Epic Games qui a été publié sous la forme de différents progiciels proposant différents modes de jeu qui partagent le même gameplay général et le même moteur de jeu.")
            ->setName("Fortnite")
            ->setPosterPath('https://cdn03.nintendo-europe.com/media/images/10_share_images/games_15/nintendo_switch_download_software_1/H2x1_NSwitchDS_Fortnite_image1600w.jpg');
        $manager->persist($fortnite);
        $lol = (new Game())
            ->setApiUrl("")
            ->setDescription("League of Legends, anciennement nommé League of Legends: Clash of Fates est un jeu vidéo de type arène de bataille en ligne gratuit développé et édité par Riot Games sur Windows et Mac OS X.")
            ->setName("League of Legends")
            ->setPosterPath('https://img.phonandroid.com/2019/05/league-of-legends-mobile.jpg');
        $manager->persist($lol);
        $manager->flush();
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        return ['demo'];
    }
}