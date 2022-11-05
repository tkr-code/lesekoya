<?php

namespace App\DataFixtures;

use App\Entity\Category3;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Category3Fixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorys3 = 
        [
            [
                'title'=>'Eléctroniques',
                'icon'=>'icon-laptop'
            ],
            [
                'title'=>'Meuble',
                'icon'=>''
            ],
            [
                'title'=>'Cuisine',
                'icon'=>''
            ],
        ];
        foreach ($categorys3 as $key => $value) {
            $category3 = new Category3();
            $category3->setTitle($value['title']);
            $category3->setIcon($value['icon']);
            $this->addReference('niveau_3'.$value['title'],$category3);
            $manager->persist($category3);
        }

        $manager->flush();
    }
}
