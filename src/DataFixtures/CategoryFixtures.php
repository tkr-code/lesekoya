<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = 
        [
            ['title' => 'Autres'],
            ['title' => 'Ordinateur'],
            ['title' => 'Smartphone'],
            ['title' => 'Mode homme'],
            ['title' => 'Chemise'],
            ['title' => 'Accessoires']
        ];

        foreach ($categories  as $key => $value) {
            $category= new Category();
            $category->setTitle($value['title']);
            $category->setIsActive(true);
            $manager->persist($category);

            //enregistre la categorie
            $this->addReference('category_'. $key, $category);
        }

        $manager->flush();
    }
}