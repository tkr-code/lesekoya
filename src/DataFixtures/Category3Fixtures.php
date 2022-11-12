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
                'icon'=>'icon-couch'
            ],
            [
                'title'=>'Cuisine',
                'icon'=>'icon-concierge-bell'
            ],
            [
                'title'=>'Vêtements',
                'icon'=>'icon-tshirt'
            ],
            [
                'title'=>'Appareils ménagers',
                'icon'=>'icon-blender'
            ],
            [
                'title'=>'Santé et Beauté',
                'icon'=>'icon-heartbeat'
            ],
            [
                'title'=>'Chaussures et bottes',
                'icon'=>'icon-shoe-prints'
            ],
            [
                'title'=>'Voyage et plein air',
                'icon'=>'icon-map-signs'
            ],
            [
                'title'=>'Téléphones intelligents',
                'icon'=>'icon-mobile-alt'
            ],
            [
                'title'=>'Télévision et audio',
                'icon'=>'icon-tv'
            ],
            [
                'title'=>'Sac à dos et Sac',
                'icon'=>'icon-shopping-bag'
            ],
            [
                'title'=>'Instruments de musique',
                'icon'=>'icon-music'
            ],
            [
                'title'=>'Idées de cadeau',
                'icon'=>'icon-gift'
            ],
        ];
        foreach ($categorys3 as $key => $value) {
            $category3 = new Category3();
            $category3->setTitle($value['title']);
            $category3->setSlug($value['title']);
            $category3->setIcon($value['icon']);
            $this->addReference('niveau_3'.$value['title'],$category3);
            $manager->persist($category3);
        }

        $manager->flush();
    }
}
