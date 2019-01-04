<?php
/**
 * Created by PhpStorm.
 * User: ldecultot
 * Date: 04/01/2019
 * Time: 15:09
 */

namespace App\DataFixtures;


use App\Entity\Type;
use App\Enums\OrganizationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $this->persistType($manager, OrganizationTypeEnum::SPONSOR, OrganizationTypeEnum::ENTITY_NAME);
        $this->persistType($manager, OrganizationTypeEnum::TEAM, OrganizationTypeEnum::ENTITY_NAME);

        $manager->flush();
    }

    private function persistType(ObjectManager &$manager, string $name, string $entityName) {
        $type = (new Type())
            ->setName($name)
            ->setEntityName($entityName);
        $manager->persist($type);
    }
}