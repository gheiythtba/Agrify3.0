<?php

namespace App\Repository;

use App\Entity\PlanteStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlanteStock>
 *
 * @method PlanteStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanteStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanteStock[]    findAll()
 * @method PlanteStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanteStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlanteStock::class);
    }

//    /**
//     * @return PlanteStock[] Returns an array of PlanteStock objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlanteStock
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
