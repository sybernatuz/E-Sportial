<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 15:09
 */

namespace App\DataFixtures;


use App\Entity\Type;
use App\Enums\type\JobTypeEnum;
use App\Enums\type\OrganizationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->persistType($manager, OrganizationTypeEnum::ENTITY_NAME, OrganizationTypeEnum::SPONSOR);
        $this->persistType($manager, OrganizationTypeEnum::ENTITY_NAME, OrganizationTypeEnum::TEAM);

        $this->persistType($manager, JobTypeEnum::ENTITY_NAME, JobTypeEnum::COACHING);
        $this->persistType($manager, JobTypeEnum::ENTITY_NAME, JobTypeEnum::WORK);

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