<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories = 
        [
            [
                'parent'=>'parent_informatique',
                'cat'=>[
                    'Ordinateurs',
                    'Claviers & Souris',
                    'Clé usb',
                    'Cable Hdmi',
                    'info Accessoires'
                ]
            ],            
            [
                'parent'=>'parent_smartphone',
                'cat'=>[
                    'Samsung',
                    'Iphone',
                    'Autre marque',
                ]
            ],            
        ];
        foreach ($categories as $key => $value) {
            $parent = $this->getReference($value['parent']);
            foreach ($value['cat'] as $key => $v) {
                $category= new Category();
                $category->setTitle($v);
                $category->setIsActive(true);
                $category->setParentCategory($parent);
                $manager->persist($category);
                $this->addReference('category_'. str_replace(' ','_',$v), $category);
            }

        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoryParent::class
        ];
    }
}