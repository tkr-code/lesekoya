<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function load(ObjectManager $manager)
    {        
        $articles = [
            [

                'cat'=>'Ordinateur portable',
                'articles'=>
                [
                    [
                        'title' => 'Hp elitebook Folio G1','price' => '200000',
                        'buy' => '150000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                        ]
                        ]
                ]
            ];

            foreach ($articles as $value) {
                $category  = $this->getReference(('category_'.str_replace(' ','_',$value['cat'])));
                foreach ($value['articles'] as $key => $value) {
                    $detail = isset($value['detail']) ? $value['detail']:'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae consequatur dicta';
                $article  = new Article();
                $article->setTitle($value['title'])
                ->setCreatedAt(new DateTime())
                ->setCategory($category)
                ->setBuyingPrice($value['buy'])
                ->setPrice($value['price'])
                ->setEnabled(true)
                ->setEtat($value['etat'])
                ->setDescription($detail)
                ->setQuantity(10)
                ->setStatus('Neuf')
                ->setQtyReel(10);
                $this->addReference('_article_'. str_replace(' ','_', $value['title']),$article);
                $manager->persist($article);
                }
            }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}