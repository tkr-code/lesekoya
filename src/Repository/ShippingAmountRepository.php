<?php

namespace App\Repository;

use App\Entity\ShippingAmount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingAmount|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingAmount|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingAmount[]    findAll()
 * @method ShippingAmount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingAmountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingAmount::class);
    }

    /**
    * @return ShippingAmount[] Returns an array of ShippingAmount objects
    */
    public function findByStreet($id_street=2)
    {
        $streets = $this->createQueryBuilder('a')
            ->join('a.street','b')
            ->andWhere("b.id = :id_street ")
            ->setParameter('id_street', $id_street)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
        foreach ($streets as $key => $value) {
            return $value->getAmount();
        }
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?ShippingAmount
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
