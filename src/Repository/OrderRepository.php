<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findState(string $state)
    {
        return $this->findQuery()
        ->where("o.state = :state ")
        ->setParameter('state',$state)
        ->getQuery()
        ->getResult();
    }
    public function findStateClient(int $id_user, string $state = null )
    {

        $query = $this->findQuery();
        if ($state != null) {
            $query
            ->where("o.state = :state ")
            ->setParameter('state',$state);
        }
       return $query
        ->andWhere("o.user = :id_user ")
        ->setParameter('id_user',$id_user)
        ->getQuery()
        ->getResult();
    }
    public function findClient(int $user)
    {
        return $this->findQuery()
        ->where("o.user = :user")
        ->setParameter('user',$user)
        ->getQuery()
        ->getResult();
    }
    public function findClientState(int $user, string $state="in progress")
    {
        return $this->findQuery()
        ->where("o.user = :user")
        ->setParameter('user',$user)
        ->andWhere("o.state = :state ")
        ->setParameter('state',$state)
        ->getQuery()
        ->getResult();
    }

    public function findExpired()
    {
        return $this->findQuery()
        ->where("o.state = 'not paid' ")
        ->getQuery()
        ->getResult();
    }
    
    public function findOrders()
    {
        return $this->findQuery()
        ->where("o.state <> 'furfiled' and o.state <> 'expired' ")
        ->getQuery()
        ->getResult();
    }

    public function findQuery()
    {
        return $this->createQueryBuilder('o');
    }
    
    public function findLast()
    {
       return $this->findQuery()
        ->orderBy('o.id','desc')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult()
        ;   
    }
    public function findAllLast()
    {
       return $this->findQuery()
        ->orderBy('o.id','desc')
        ->getQuery()
        ->getResult()
        ;   
    }

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}