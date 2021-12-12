<?php

namespace App\DataFixtures;

use App\Entity\ShippingAmount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $montant = 0;
        for($i=0; $i< 100 ;$i++){
            $shippingAmount = new ShippingAmount();
            $shippingAmount->setAmount($montant);
            $manager->persist($shippingAmount);
            $this->addReference('ref_shipping_amount_'.$montant,$shippingAmount);
            $montant = $montant +100;
        }
        $manager->flush();
    }
}
