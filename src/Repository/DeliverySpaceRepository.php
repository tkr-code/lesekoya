<?php

namespace App\Repository;

use App\Entity\DeliverySpace;
use App\Entity\Order;
use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeliverySpace|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliverySpace|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliverySpace[]    findAll()
 * @method DeliverySpace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliverySpaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliverySpace::class);
    }

    public function findbyStreetOrder()
    {
        return $this->createQueryBuilder('d')
            // ->leftjoin('order','o')
            ->where('d.street = 36')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?DeliverySpace
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
