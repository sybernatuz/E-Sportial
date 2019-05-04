<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Entity\Search\MemberSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Organization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organization[]    findAll()
 * @method Organization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Organization::class);
    }

    public function findByType(int $organizationsNumber, string $type) : array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.type', 't')
            ->where('t.name = :type')
            ->setParameter('type', $type)
            ->setMaxResults($organizationsNumber)
            ->getQuery()
            ->getResult();
    }

    /**
     * Used for pagination
     * @param MemberSearch $search
     * @return Query
     */
    public function findTeamBySearch(MemberSearch $search): Query
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.slug, t.name, t.logoPath, c.flagPath, c.name as flagName, count(s) as followers')
            ->innerJoin('t.type', 'ty')
            ->innerJoin('t.country', 'c')
            ->leftJoin('t.subscriptions', 's')
            ->where('ty.name = \'team\'')
            ->groupBy('t.id, c.id');

        if ($word = $search->getWord()) {
            $query->andWhere('t.name LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($country = $search->getCountry()) {
            $query->andWhere('c.name = :country')
                ->setParameter('country', $country->getName());
        }

        return $query->getQuery();
    }

}
