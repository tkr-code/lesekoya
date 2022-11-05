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
        $faker = Faker\Factory::create();

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
                    ],
                    [
                        'title' => 'Hp elitebook Folio G2','price' => '200000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Hp 2343243','price' => '200000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Dell 234234','price' => '234000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Hp 324343','price' => '200000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Dell 23434','price' => '133000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Dell 23234','price' => '89000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Dell'
                    ],
                    [
                        'title' => 'Dell 233 ','price' => '200000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Dell'
                    ],
                    [
                        'title' => 'Hp proberbok ','price' => '273000',
                        'buy' => '134000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Hp'
                    ],
                    [
                        'title' => 'Hp e','price' => '200000',
                        'buy' => '120000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Très mince et léger avec un design et un assemblage haut de gamme, un grand clavier très confortable pour un ordinateur ultraportable,',
                        'brand'=>'Hp'
                    ],
                ]
            ],
            [
                'cat'=>'Clé usb',
                'articles'=>
                [
                    [
                        'title' => 'Usb 2go','price' => '2000',
                        'buy' => '2000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 4go','price' => '4000',
                        'buy' => '2000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 8go','price' => '8000',
                        'buy' => '2000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 16go','price' => '12000',
                        'buy' => '20000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 32go','price' => '18000',
                        'buy' => '20000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 64go','price' => '40000',
                        'buy' => '20000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                    [
                        'title' => 'Usb 128Go','price' => '100000',
                        'buy' => '20000',
                        'etat'=>'Meilleurs ventes',
                        'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                        'brand'=>'Imation'
                    ],
                ]
                ],
                [
                    'cat'=>'Accessoires',
                    'articles'=>[
                        [
                            'title'=>'Chargeur 2323',
                            'buy' => '10000',
                            'etat'=>'Meilleurs ventes',
                            'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                            'brand'=>''

                        ],
                        [
                            'title'=>'Clavier Hp',
                            'buy' => '10000',
                            'etat'=>'Meilleurs ventes',
                            'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                            'brand'=>'Hp'
                        ],
                        [
                            'title'=>'Clavier Sans fil Hp',
                            'buy' => '10000',
                            'etat'=>'Meilleurs ventes',
                            'detail'=>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet eligendi nam quod labore eos vitae, nihil soluta quam consequuntur reiciendis delectus ipsa placeat deleniti, tempora commodi est, accusamus unde ex?,',
                            'brand'=>'Hp'

                        ],
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
                ->setPrice($faker->numberBetween(1000,1000000))
                ->setEnabled(true)
                ->setEtat($value['etat'])
                ->setDescription($faker->text(5))
                ->setQuantity(10)
                ->setStatus('Neuf')
                ->setQtyReel(10);
                $this->addReference('_article_'. str_replace(' ','_', $value['title']),$article);
                $manager->persist($article);
                $manager->flush();
                $article->setRef($article->getId());
                }
            }
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}