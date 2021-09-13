<?php

namespace App\Repository;

use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Street|null find($id, $lockMode = null, $lockVersion = null)
 * @method Street|null findOneBy(array $criteria, array $orderBy = null)
 * @method Street[]    findAll()
 * @method Street[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Street::class);
    }
     /**
     * @return Street[] Returns an array of City objects
     */
    public function findbyCities($id_city)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.city = :id_city')
            ->setParameter('id_city', $id_city)
            ->getQuery()
            ->getResult()
        ;
    }
     /**
     * @return Street[] Returns an array of City objects
     */
    public function findbyCity($city_name = 'Dakar')
    {
        return $this->createQueryBuilder('c')
            ->join('c.city','b')
            ->andWhere('b.name = :city_name')
            ->setParameter('city_name', $city_name)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Street[] Returns an array of Street objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Street
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}