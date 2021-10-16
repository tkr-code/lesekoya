<?php

namespace App\DataFixtures;

use App\Entity\Street;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StreetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $streets = 
        [
            'Sacre coeur'
        ];
         $street = new Street();
        // $manager->persist($product);

        $manager->flush();
    }
}
