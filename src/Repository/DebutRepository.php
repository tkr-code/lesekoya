<?php

namespace App\Repository;

use App\Entity\Debut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Debut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Debut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Debut[]    findAll()
 * @method Debut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DebutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Debut::class);
    }

    // /**
    //  * @return Debut[] Returns an array of Debut objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Debut
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
