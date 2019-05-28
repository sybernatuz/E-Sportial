<?php

namespace App\Repository;

use App\Entity\Job;
use App\Entity\Search\JobSearch;
use App\Entity\User;
use App\Enums\type\JobTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    private $token;

    public function __construct(RegistryInterface $registry, TokenStorageInterface $token)
    {
        parent::__construct($registry, Job::class);
        $this->token = $token;
    }

    /**
     * Used for pagination
     * @param JobSearch $search
     * @return Query
     */
    public function findBySearchOrderByLastDate(JobSearch $search): Query
    {
        $query = $this->createQueryBuilder('j')
            ->orderBy('j.createdAt', 'DESC');

        if ($word = $search->getWord()) {
            $query->andWhere('j.title LIKE :word')
                ->setParameter('word', '%' . $word . '%');
        }

        if ($location = $search->getLocation()) {
            $query->andWhere('j.location LIKE :location')
                ->setParameter('location', '%' . $location . '%');
        }

        if ($this->token->getToken()->getUser() instanceof User && $this->token->getToken()->getUser()->getId() != null) {
            $query->leftJoin('j.user', 'u')
                ->andWhere('u.id != :id')
                ->setParameter('id', $this->token->getToken()->getUser()->getId());
        }

        $type = $search->getType() != null ? $search->getType()->getName() : JobTypeEnum::WORK;
        $query->leftJoin('j.type', 't')
            ->andWhere('t.name = :type')
            ->setParameter('type', $type);

        return $query->getQuery();
    }

    public function findByLastDateAndType(int $jobsNumber, string $type)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type)
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults($jobsNumber)
            ->getQuery()
            ->getResult();
    }

    public function findByUserApplied(int $id, User $user)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.applicants', 'a')
            ->where('j.id = :id')
            ->setParameter(':id', $id)
            ->andWhere('a = :applicant')
            ->setParameter(':applicant', $user)
            ->getQuery()
            ->getResult();
    }

    public function findByCreatorAndType(User $user, string $type)
    {
        return $this->createQueryBuilder('j')
            ->leftJoin('j.type', 't')
            ->where('t.name = :type')
            ->setParameter(':type', $type)
            ->andWhere('j.user = :user')
            ->setParameter(':user', $user)
            ->getQuery()
            ->getResult();
    }
}
