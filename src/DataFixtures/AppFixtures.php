<?php

namespace App\DataFixtures;

use App\Entity\ShippingAmount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $shippingAmounts = 
        [
            '500','1000','1500','2000','2500'
        ];
        foreach ($shippingAmounts as $value)
        {
            $shippingAmount = new ShippingAmount();
            $shippingAmount->setAmount($value);
            $manager->persist($shippingAmount);
        }
        $manager->flush();
    }
}
