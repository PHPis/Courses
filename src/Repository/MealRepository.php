<?php

namespace App\Repository;

use App\Entity\Ingestion;
use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, Paginator $paginator)
    {
        parent::__construct($registry, Meal::class);
        $this->paginator = $paginator;
    }

    public function getAllMealQuery()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10);
    }

    public function getAllMealPaginator(int $page = 1, int $countObj = 10): ?PaginationInterface
    {
        $query = $this->getAllMealQuery();
        return $this->paginator->paginate(
            $query,
            $page,
            $countObj
        );
    }

    public function searchQueryBuilder(string $name, ?array $ingestionIds)
    {
        $query = $this->createQueryBuilder('m')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10);

        $query->andWhere($query->expr()->like('m.name', ':name'))
        ->setParameter('name', '%'.$name.'%');

        if ($ingestionIds) {
            $query->innerJoin('m.ingestion', 'i')
                ->andWhere($query->expr()->in('i.id', ':ingestion'))
                ->setParameter('ingestion', $ingestionIds)
            ;
        }

        return $query;
    }

    public function searchQueryPaginator(string $name,
                                ?array $ingestionIds,
                                int $page = 1,
                                int $countObj = 10): ?PaginationInterface
    {
        $query = $this->searchQueryBuilder($name, $ingestionIds);
        return $this->paginator->paginate(
            $query,
            $page,
            $countObj
        );
    }

    // /**
    //  * @return Meal[] Returns an array of Meal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
