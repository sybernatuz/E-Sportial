<?php
/**
 * Created by PhpStorm.
 * User: Louis
 * Date: 01/01/2019
 * Time: 22:00
 */

namespace App\DataFixtures\dev;


use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Asset\Packages;

class GameFixtures extends Fixture implements FixtureGroupInterface
{
    private $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $game = (new Game())
                ->setApiUrl($faker->url)
                ->setDescription($faker->text)
                ->setName($faker->name)
                ->setPosterPath('defaultPoster.jpg');
            $manager->persist($game);
        }
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
        return ['dev'];
    }
}