<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

     /**
     * @return City[] Returns an array of City objects
     */
    public function findbyCountry($id_country)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.country = :id_country')
            ->setParameter('id_country', $id_country)
            ->getQuery()
            ->getResult()
        ;
    }
     /**
     * @return City[] Returns an array of City objects
     */
    public function findbyCountryName($country_name = "Sénégal")
    {
        return $this->createQueryBuilder('c')
            ->join('c.country','b')
            ->andWhere('b.name = :country_name')
            ->setParameter('country_name', $country_name)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?City
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}