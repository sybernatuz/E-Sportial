<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 15:09
 */

namespace App\DataFixtures;


use App\Entity\Type;
use App\Enums\type\EntityNameEnum;
use App\Enums\type\EventTypeEnum;
use App\Enums\type\JobTypeEnum;
use App\Enums\type\OrganizationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
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
}