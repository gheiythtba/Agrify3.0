<?php

namespace App\Repository;

use App\Entity\StockDivers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockDivers>
 *
 * @method StockDivers|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockDivers|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockDivers[]    findAll()
 * @method StockDivers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockDiversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockDivers::class);
    }

//    /**
//     * @return StockDivers[] Returns an array of StockDivers objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StockDivers
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findAllWithSelectedColumns()
    {
        return $this->createQueryBuilder('d')
            ->select('d.id', 'd.nomSD','d.quantiteSD', 'd.health', 'd.dateEntreeStock', 'd.prix')
            ->getQuery()
            ->getResult();
    }

    public function getStockEvolutionData()
{
    $result = $this->createQueryBuilder('d')
        ->select("SUBSTRING(d.dateEntreeStock, 1, 10) as date, COUNT(d.id) as stock")
        ->groupBy('date')
        ->orderBy('date')
        ->getQuery()
        ->getResult();

    $formattedData = [];

    foreach ($result as $entry) {
        $formattedData[] = [$entry['date'], (int) $entry['stock']];
    }

    return $formattedData;
}
}
