<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
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
        $faker = Faker\Factory::create('fr_FR');
        $articles = 
        [
            [
                'cat'=>'Ordinateurs',
                'articles'=>
                [
                    [
                        'title' => 'Hp probook','price' => '150000',
                        'buy' => '120000',
                        'etat'=>'Tendance'
                    ],
                    [
                        'title' => 'Dell Lattitude','price' => '200000',
                        'buy' => '150000',
                        'etat'=>'Tendance'
                    ],
                    [
                        'title' => 'Mac probook','price' => '300000',
                        'buy' => '200000',
                        'etat'=>'Tendance'
                    ],
                ]
            ],
            [
                'cat'=>'Clé usb',
                'articles'=>
                [
                    [
                        'title' => 'Clé Usb 32 go','price' => '10000',
                        'buy' => '6000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Clé Usb 4 go','price' => '4000',
                        'buy' => '3000',
                        'etat'=>'Top'
                    ]
                ]
            ],
            [
                'cat'=>'Samsung',
                'articles'=>
                [
                    [
                        'title' => 'Galaxy S6 edge','price' => '300000',
                        'buy' => '250000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Galaxy S7 edge','price' => '400000',
                        'buy' => '250000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Galaxy S5','price' => '190000',
                        'buy' => '250000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'J 6 2020','price' => '120000',
                        'buy' => '100000',
                        'etat'=>"Tendance"
                    ]
                ]
            ],
            [
                'cat'=>'Iphone',
                'articles'=>
                [
                    [
                        'title' => 'Iphone 13','price' => '900000',
                        'buy' => '700000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Iphone 12','price' => '760000',
                        'buy' => '700000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Iphone 11','price' => '800000',
                        'buy' => '700000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Iphone 8','price' => '400000',
                        'buy' => '700000',
                        'etat'=>'Top'
                    ],
                    [
                        'title' => 'Airpod','price' => '40000',
                        'buy' => '30000',
                        'etat'=>'Tendance'
                    ]
                ]
            ],
        ];

            foreach ($articles as $value) {
                $category  = $this->getReference(('category_'.str_replace(' ','_',$value['cat'])));
                foreach ($value['articles'] as $key => $value) {
                $article  = new Article();
                $article->setTitle($value['title'])
                ->setCategory($category)
                ->setBuyingPrice($value['buy'])
                ->setPrice($value['price'])
                ->setEnabled(true)
                ->setEtat($value['etat'])
                ->setDescription('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae consequatur dicta,')
                ->setQuantity(10)
                ->setQtyReel(10);
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