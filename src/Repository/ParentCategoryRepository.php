<?php

namespace App\Repository;

use App\Entity\ParentCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParentCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentCategory[]    findAll()
 * @method ParentCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentCategory::class);
    }

    public function query(){
        return $this->createQueryBuilder('o');
    }
    public function etat(string $etat){
        $query = $this->query();
        $query->andWhere('o.is_active = :etat')
        ->setParameter('etat',$etat);
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return ParentCategory[] Returns an array of ParentCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParentCategory
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
