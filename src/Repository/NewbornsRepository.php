<?php

namespace App\Repository;

use App\Entity\Newborns;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Newborns>
 *
 * @method Newborns|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newborns|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newborns[]    findAll()
 * @method Newborns[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewbornsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newborns::class);
    }

    /**
     *  @param string $species
     * @return Newborns[] Returns an array of Newborns objects
     */
    public function findBySpecies(string $species): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.espece = :species')
            ->setParameter('species', $species)
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Newborns
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
