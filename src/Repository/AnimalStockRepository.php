<?php

namespace App\Repository;

use App\Entity\AnimalStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<AnimalStock>
 *
 * @method AnimalStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimalStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimalStock[]    findAll()
 * @method AnimalStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimalStock::class);
    }

//    /**
//     * @return AnimalStock[] Returns an array of AnimalStock objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnimalStock
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


// src/Repository/AnimalStockRepository.php


    public function findAllWithSelectedColumns()
    {
        return $this->createQueryBuilder('a')
            ->select('a.id', 'a.nomAnimal', 'a.sexeAnimal', 'a.ageAnimal', 'a.poidsAnimal', 'a.health', 'a.dateEntreeStock', 'a.prix')
            ->getQuery()
            ->getResult();
    }
 
    public function getStockEvolutionData()
{
    $result = $this->createQueryBuilder('a')
        ->select("SUBSTRING(a.dateEntreeStock, 1, 10) as date, COUNT(a.id) as stock")
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
public function filterAnimalStocks(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        if ($criteria['nomAnimal']) {
            $queryBuilder->andWhere('a.nomAnimal LIKE :nomAnimal')
                ->setParameter('nomAnimal', '%' . $criteria['nomAnimal'] . '%');
        }

        if ($criteria['sexeAnimal']) {
            $queryBuilder->andWhere('a.sexeAnimal = :sexeAnimal')
                ->setParameter('sexeAnimal', $criteria['sexeAnimal']);
        }

        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }

    // src/Repository/AnimalStockRepository.php

    public function findBySearchTerm(string $searchTerm): array
    {
        $queryBuilder = $this->createQueryBuilder('a');
    
        if ($searchTerm) {
            $queryBuilder
                ->andWhere('a.nomAnimal LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
}
