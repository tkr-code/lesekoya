<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array(
            array('id' => '2','title' => 'Ordinateur'),
            array('id' => '3','title' => 'Smartphone'),
            array('id' => '4','title' => 'Mode homme'),
            array('id' => '5','title' => 'Chemise'),
            array('id' => '6','title' => 'Accessoires')
        );
        foreach ($categories as $value) {
            $category= new Category();
            $category->setTitle($value['title']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}