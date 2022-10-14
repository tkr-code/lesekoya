<?php

namespace App\Repository;

use App\Entity\ArticleBuy;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleBuy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleBuy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleBuy[]    findAll()
 * @method ArticleBuy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleBuyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleBuy::class);
    }
    public function findQuery(){
        return $this->createQueryBuilder('o');
    }
    public function isBuy($client, Article $article){
        $query = $this->findQuery();
        $query
            ->where('o.article = :article_id and o.client = :client_id' )
            ->setParameter('article_id',$article->getId())
            ->setParameter('client_id',$client->getId())
            ;
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return ArticleBuy[] Returns an array of ArticleBuy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleBuy
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
