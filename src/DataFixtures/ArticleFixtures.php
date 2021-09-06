<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
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
                'title' => 'Hp probook','price' => '150000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '120000'
            ],
            [
                'title' => 'Clavier sans fil','price' => '6000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '10000'
            ],
            [
                'title' => 'Chargeur Pc 15','price' => '10000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '5000'
            ],
            [
                'title' => 'Ecouteur Iphone','price' => '2500','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '1500'
            ],
            [
                'title' => 'Cle USB 32 go','price' => '5000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '2500'
            ],
            [
                'title' => 'Cle USB 8 go','price' => '3500','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '2500'
            ],
            [
                'title' => 'Cle USB 4 go','price' => '3000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '2500'
            ],
            [
                'title' => 'Cle USB 2 go','price' => '2000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '2500'
            ],
            
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6 edge','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Iphone 8','price' => '70000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '60000'
            ],
            [
                'title' => 'Iphone 6','price' => '70000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '60000'
            ],
            [
                'title' => 'Iphone 9','price' => '70000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '60000'
            ],
            [
                'title' => 'Chargeur Iphone','price' => '2000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '1000'
            ],
            [
                'title' => 'Iphone 12 pro','price' => '500000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '400000'
            ],
            [
                'title' => 'Cable HDMI 1,5m','price' => '130000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Galaxy S6','price' => '120000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
            [
                'title' => 'Hp elitebook 2170p','price' => '120000','description' => 'Praesentium ea dolorum aut accusantium modi.',
                'buying_price' => '100000'
            ],
        ];
        $category = new Category();
        $category->setTitle('Autres');
        $manager->persist($category);
        $manager->flush();

            foreach ($articles as $value) {
                $article  = new Article();
                $article->setTitle($value['title'])
                ->setCategory($category)
                ->setBuyingPrice($value['buying_price'])
                ->setPrice($value['price'])
                ->setEnabled(true)
                ->setDescription($value['description'])
                ->setQuantity(10);
                $manager->persist($article);
            }

        $manager->flush();
    }
}