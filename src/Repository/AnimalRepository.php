<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 *
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    /**
     * @param string $species
     * @return Animal[] Returns an array of Animal objects
     */
    public function findBySpecies(string $keyword): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.espece LIKE :keyword OR a.sexe LIKE :keyword OR CAST(a.poids AS TEXT) LIKE :keyword OR a.age LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->getQuery()
            ->getResult();
    }
    

    /**
     * @param string $sortDirection
     * @return Animal[] Returns an array of Animal objects
     */
    public function findAllSortedByEspece(string $sortDirection): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->orderBy('a.espece', $sortDirection);

        return $queryBuilder->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?Animal
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
