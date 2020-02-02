<?php

namespace App\Repository;

use App\Entity\UserDayMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserDayMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDayMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDayMeal[]    findAll()
 * @method UserDayMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDayMealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDayMeal::class);
    }

    // /**
    //  * @return UserDayMeal[] Returns an array of UserDayMeal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserDayMeal
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
