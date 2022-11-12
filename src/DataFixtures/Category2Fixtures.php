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
                'parent'=>'Eléctroniques',
                'cat'=>[
                    'Ordinateurs portable et Ordinateur',
                    'Téléphone portable',
                    'Télévision et vidéo',
                    'Caméras digitales'
                ]
            ],
            [
                'parent'=>'Meuble',
                'cat'=>[
                    'Chambre',
                    'Salon',
                    'Bureau',
                    'Cuisine et salle à manger',
                ]
            ],
            [
                'parent'=>'Cuisine',
                'cat'=>[
                    'Ustensiles de cuisine',
                    'Appareils de cuisson',
                    'Vaisselle et dessus de table',
                ]
            ],
            [
                'parent'=>'Vêtements',
                'cat'=>[
                    'Hommes',
                    'Femmes',
                ]
            ]
            // [
            //     'parent'=>'Téléphones portables',
            //     'cat'=>[
            //         "Téléphones de l'opérateur",
            //         'Téléphones déverrouillés',
            //         'Étuis pour téléphones portables',
            //         'Chargeurs de téléphones portables',
            //     ]
            // ],
            // [
            //     'parent'=>'Caméras digitales',
            //     'cat'=>[
            //         'Appareils photo reflex numériques',
            //         "Caméras de sport et d'action"
            //     ]
            // ]

        ];
        foreach ($categorys as $key => $value) {
            $parent = $this->getReference('niveau_3'.$value['parent']);
            foreach ($value['cat'] as $key => $value2) {
                $category3 = new Category2();
                $category3->setTitle($value2);
                $category3->setSlug($value2);
                $category3->setCategory3($parent);
                $this->addReference('niveau_2'.str_replace(' ','_',$value2),$category3);
                $manager->persist($category3);
            }
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
