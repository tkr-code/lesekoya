<?php

namespace App\DataFixtures;

use App\Entity\Category2;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Category2Fixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categorys = 
        [
            [
                'title'=>'Ordinateurs portable & Bureau',
                'parent'=>'Eléctroniques'
            ],
            [
                'title'=>'Téléphone portable',
                'parent'=>'Eléctroniques'
            ],
            [
                'title'=>'Caméra Digital',
                'parent'=>'Eléctroniques'
            ],
        ];
        foreach ($categorys as $key => $value) {
            $category3 = new Category2();
            $category3->setTitle($value['title']);
            $category3->setCategory3($this->getReference('niveau_3'.$value['parent']));
            $this->addReference('niveau_2'.str_replace(' ','_',$value['title']),$category3);
            $manager->persist($category3);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Category3Fixtures::class
        ];
    }
}
