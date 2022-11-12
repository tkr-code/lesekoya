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
                'parent'=>'Ordinateurs portable et Ordinateur',
                'cat'=>[
                    'Ordinateur portable',
                    'Ordinateur de Bureau',
                    'Accessoires',
                    'Clé usb',
                    'Claviers et Souris',
                    'Cable Hdmi',
                    'Imprimante et accessoires',
                    'Mémoire',
                    'Reseaux informatiques',
                    'Ecran PC',
                    'Visiophone'
                ]
            ],
            [
                'parent'=>'Téléphone portable',
                'cat'=>[
                    "Téléphones de l'opérateur",
                    'Téléphones déverrouillés',
                    'Étuis pour téléphones portables',
                    'Chargeurs de téléphones portables',
                ]
            ],                       
            [
                'parent'=>'Télévision et vidéo',
                'cat'=>[
                    "Téléviseurs",
                    'Haut-parleurs audio pour la maison',
                    'Projecteurs',
                    'Périphériques de diffusion multimédia'
                ]
            ],                       
            [
                'parent'=>'Caméras digitales',
                'cat'=>[
                    'Appareils photo reflex numériques',
                    "Caméras de sport et d'action",
                    "Caméscopes",
                    'Objectifs de caméra',
                    'Imprimante photo',
                    'Cartes mémoire numériques',
                    'Sacs photo, sacs à dos et étuis'
                ]
            ],
            [
                'parent'=>'Chambre',
                'cat'=>[
                    'Lits, cadres et sommiers',
                    'Commodes',
                    'Tables de chevet',
                    'Lits et têtes de lit pour enfants',
                    'Armoires'
                ],
            ],     
            [
                'parent'=>'Bureau',
                'cat'=>[
                    'Chaises de bureau',
                    'Bureaux',
                    'Bibliothèques',
                    'Classeurs'
                ]
            ],                
            [
                'parent'=>'Salon',
                'cat'=>[
                    'Table à café',
                    'Chaises',
                    'les tables',
                    'Futons et canapés-lits',
                    'Armoires et coffres'
                ]
            ],                  
            [
                'parent'=>'Cuisine et salle à manger',
                'cat'=>[
                    'Ensembles de salle à manger',
                    'Armoires de rangement de cuisine',
                    'Supports de boulangers',
                    'Chaises de salle à manger',
                    'Tables de salle à manger',
                    'Tabourets de bar'
                ]
            ],                  
            [
                'parent'=>'Ustensiles de cuisine',
                'cat'=>[
                    'Batteries de cuisine',
                    'Poêles, plaques chauffantes et woks',
                    'Casseroles',
                    'Poêles et poêles à griller',
                    'Bouilloires',
                    'Soupe et marmites'
                ]
            ],                  
            [
                'parent'=>'Appareils de cuisson',
                'cat'=>[
                    'Micro-ondes',
                    'Cafetières',
                    'Mélangeurs et accessoires',
                    'Mijoteuses',
                    'Friteuses à air',
                    'Grille-pain et fours'
                ]
            ],                  
            [
                'parent'=>'Vaisselle et dessus de table',
                'cat'=>[
                    'Assiettes',
                    'Tasses et mugs',
                    'Plateaux & Plats',
                    'Service de café et de thé',
                    'Salière et poivrière'
                ]
            ],                  
            [
                'parent'=>'Hommes',
                'cat'=>[
                    'Chaussures',
                    'Sacs',
                    'Accessoires Hommes',
                    'Bijoux & Montres'
                ]
            ],                  
            [
                'parent'=>'Femmes',
                'cat'=>[
                    'Chaussures Femmes',
                    'Sacs Femmes',
                    'Accessoires Femmes',
                    'Bijoux & Montres femmes'
                ]
            ],                  
        ];
        foreach ($categories as $key => $value) {
            $parent = $this->getReference('niveau_2'.str_replace(' ','_',$value['parent']));
            foreach ($value['cat'] as $key => $v) {
                $category= new Category();
                $category->setTitle($v);
                $category->setIsActive(true);
                $category->setCategory2($parent);
                $manager->persist($category);
                $this->addReference('category_'. str_replace(' ','_',$v), $category);
            }

        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            Category2Fixtures::class
        ];
    }
}