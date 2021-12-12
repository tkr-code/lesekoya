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
                'name'=>'Sacre ceour 2',
                'montant'=>1000
            ],
            [
                'name'=>'Wakam',
                'montant'=>1500
            ],
            [
                'name'=>'Liberté 4',
                'montant'=>500
            ],
        ];
        foreach ($streets as $key => $value) {
            $street = new Street();
            $street->setName($value['name'])
            ->setShippingAmount($this->getReference('ref_shipping_amount_'.$value['montant']))
            ->setCity($this->getReference('Dakar'));
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
