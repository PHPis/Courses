<?php

namespace App\Repository;

use App\Entity\UserDiet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserDiet|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDiet|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDiet[]    findAll()
 * @method UserDiet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDietRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDiet::class);
    }

    // /**
    //  * @return UserDiet[] Returns an array of UserDiet objects
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
    public function findOneBySomeField($value): ?UserDiet
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
