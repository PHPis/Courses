<?php

namespace App\Repository;

use App\Entity\Ingestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;


/**
 * @method Ingestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ingestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ingestion[]    findAll()
 * @method Ingestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngestionRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, Paginator $paginator)
    {
        parent::__construct($registry, Ingestion::class);
        $this->paginator = $paginator;
    }

    public function getAllIngestionQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.priority', 'ASC')
            ->setMaxResults(10);
    }

    public function getAllIngestionPaginator(int $page = 1, int $countObj = 10): ?PaginationInterface
    {
        $query = $this->getAllIngestionQuery();
        return $this->paginator->paginate(
            $query,
            $page,
            $countObj
        );

    }
    // /**
    //  * @return Ingestion[] Returns an array of Ingestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ingestion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
