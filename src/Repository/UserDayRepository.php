<?php

namespace App\Repository;

use App\Entity\UserDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDay[]    findAll()
 * @method UserDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDay::class);
    }

    // /**
    //  * @return UserDay[] Returns an array of UserDay objects
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
    public function findOneBySomeField($value): ?UserDay
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
