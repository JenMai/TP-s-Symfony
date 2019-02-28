<?php

namespace App\Repository;

use App\Entity\ActionUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ActionUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionUser[]    findAll()
 * @method ActionUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ActionUser::class);
    }

    // /**
    //  * @return ActionUser[] Returns an array of ActionUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActionUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
