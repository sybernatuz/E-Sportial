<?php


namespace App\DataFixtures\demo;


use App\Entity\Type;
use App\Enums\entity\EntityNameEnum;
use App\Enums\type\EventTypeEnum;
use App\Enums\type\JobTypeEnum;
use App\Enums\type\OrganizationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixturesDemo extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $this->persistType($manager, EntityNameEnum::ENTITY_NAME_ORGANIZATION, OrganizationTypeEnum::SPONSOR);
        $this->persistType($manager, EntityNameEnum::ENTITY_NAME_ORGANIZATION, OrganizationTypeEnum::TEAM);

        $this->persistType($manager, EntityNameEnum::ENTITY_NAME_JOB, JobTypeEnum::COACHING);
        $this->persistType($manager, EntityNameEnum::ENTITY_NAME_JOB, JobTypeEnum::WORK);

        $this->persistType($manager, EntityNameEnum::ENTITY_NAME_EVENT, EventTypeEnum::TOURNAMENT);

        $manager->flush();
    }

    private function persistType(ObjectManager &$manager, string $entityName, string $name)
    {
        $type = (new Type())
            ->setName($name)
            ->setEntityName($entityName);
        $manager->persist($type);
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