<?php

namespace App\DataFixtures;

use App\Entity\Street;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StreetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $streets=[
            [
                'name'=>'Wakam',
                'montant'=>1300
            ],
            [
                'name'=>'Médina',
                'montant'=>500
            ],
            [
                'name'=>'Fass',
                'montant'=>500
            ],
            [
                'name'=>'Grand Dakar',
                'montant'=>500
            ],
            [
                'name'=>'Grand Yoff',
                'montant'=>500
            ],
            [
                'name'=>'Almadie',
                'montant'=>1000
            ],
            [
                'name'=>'Sacre ceour 1',
                'montant'=>1000
            ],
            [
                'name'=>'Sacre ceour 2',
                'montant'=>1000
            ],
            [
                'name'=>'Sacre ceour 3',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 1',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 2',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 3',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 4',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 5',
                'montant'=>1000
            ],
            [
                'name'=>'Liberté 6',
                'montant'=>1400
            ],
            [
                'name'=>'Liberté 6 extension',
                'montant'=>1500
            ],
            [
                'name'=>'Ouest-foire',
                'montant'=>1500
            ],
            [
                'name'=>'Nord-foire',
                'montant'=>1500
            ],
            [
                'name'=>'Sud-foire',
                'montant'=>1500
            ],
            [
                'name'=>'Est-foire',
                'montant'=>1500
            ],
        ];
        foreach ($streets as $key => $value) {
            $street = new Street();
            $street->setName($value['name'])
            ->setShippingAmount($this->getReference('ref_shipping_amount_'.$value['montant']))
            ->setCity($this->getReference('Dakar'));
            $this->addReference('_street_'.str_replace(' ','_', $value['name']),$street);
            $manager->persist($street);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CitiesFixtures::class,
            AppFixtures::class
        ];
    }
}
