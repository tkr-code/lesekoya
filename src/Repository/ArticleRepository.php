<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\ArticleSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

        /**
     * Recheche les articles en fonctions du formulaire
     *
     * @param  mixed $var
     * @return void
     */
    public function search($mots=null, $category=null, $min=null, $max= null, $brand = null, $etat = null)
    {
        $query = $this->findQueryBuilder()
        ->AndWhere('p.enabled = true');
        
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(p.title, p.description) AGAINST(:mots boolean) > 0')
            ->setParameter('mots',$mots);
        }
        if($min != null){
            $query
            ->andWhere("p.price >= :minprix")
            ->setParameter("minprix",$min);
            }
        if($max != null){
            $query
                ->andWhere("p.price <= :maxprix")
                ->setParameter("maxprix",$max);
        }
        if($etat != null){
            $query
                ->andWhere("p.status = :etat")
                ->setParameter("etat",$etat);
        }
        if($brand != null){
            $query
                ->leftJoin('p.brand', 'b')
                ->andWhere("b.name = :brand")
                ->setParameter("brand",$brand);
        }
        if($category != null){
            $query->leftJoin('p.category', 'c');
            $query->andWhere('c.title = :title')
            ->setParameter('title',$category);
        } 
        return $query->getQuery();
    }
    public function findCategoryTitle(string $category, string $etat =''){
        $query = $this->findQueryBuilder();
        $query->leftJoin('p.category', 'c');
            $query->andWhere('c.title = :title');
            $query->setParameter('title',$category);
            if(!empty($etat)){
                $query->andWhere('p.etat = :etat');
                $query->setParameter('etat',$etat);
            }
            return $query->getQuery()->getResult();
    }
    public function showPagination(){
        $query = $this->findQueryBuilder();
        // $query->
        return $query->getQuery();
    }
        /**
     * Recheche les articles en fonctions du formulaire
     *
     * @param  mixed $var
     * @return void
     */
    public function searchJson($mots=null)
    {
        $query = $this->findQueryBuilder()
        ->AndWhere('p.enabled = true');
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(p.title, p.description) AGAINST(:mots boolean) > 0')
            ->setParameter('mots',$mots);
        }
       $articles = $query->getQuery()->getResult();
        $suggestions = [];
       foreach($articles as $v){
        $suggestions[]= [
            'id'=>$v->getId(),
            'name'=>$v->getTitle(),
            'link'=>'',
            'image'=>''
        ];
       }
       return $suggestions;
    }

    /**
     * @return Query[]
     */
    public function findAllOnQuery(ArticleSearch $Search){
        // $Search->setMaxPrice(10000);
        $query =  $this->findQueryBuilder()
            ->andwhere("p.enabled = true");
            // ->setParameter('activer',true);

            if($Search->getMaxPrice()){
                $query
                ->andWhere("p.price <= :maxprice ")
                ->setParameter("maxprix",$Search->getMaxPrice());
            }
            if($Search->getMinPrice()){
                $query
                ->andWhere("p.price >= :minprice ")
                ->setParameter("minprix",$Search->getMinPrice());
            }
            
           return $query->getQuery();
    }
    public function recently()
    {
        return $this->findQueryBuilder()
            ->orderBy('p.id','DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
    public function findAllOff()
    {
        return $this->findQueryBuilder()
            ->where("p.enabled = false ")
            ->getQuery()
            ->getResult();
    }
    public function findCountOnline()
    {
        return count($this->findAllOn());
    }
    public function findAllOn()
    {
        return $this->findQueryBuilder()
            ->where("p.enabled = true ")
            ->getQuery()
            ->getResult();
    }
    public function findEtat($etat = null)
    {
        return $this->findQueryBuilder()
            ->where("p.etat = :etat ")
            ->setParameter('etat',$etat)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    public function findRand(int $maxResults = 10, Article $article = null)
    {
        return $this->findQueryBuilder()
            ->addSelect('RAND() as HIDDEN rand')
            ->where('p.id <> :id')
            ->setParameter('id',$article == null ? 0: $article->getId() )
            ->orderBy('rand')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
    public function findAllOnArray()
    {
        return $this->findQueryBuilder()
            ->where("p.enabled = true ")
            ->getQuery()
            ->getArrayResult();
            // ->getResult();
    }

    
    public function findQueryBuilder()
    {
        return $this->createQueryBuilder('p');
    }

       /**
     * Vérifie si l'article est en favoris en fonction du user
     *
     */
    public function isFavoris(User $user, Article $article){
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM article_user f
            WHERE f.article_id = :article_id and f.user_id = :user_id
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'article_id'=>$article->getId(),
            'user_id'=>$user->getId()
        ]);
        if(empty($resultSet->fetchAllAssociative())){
            return false;
        }else{
            return true;
        }
        return false;
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
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