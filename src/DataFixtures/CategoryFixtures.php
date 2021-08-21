<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category =
        [
            'Divers',
            'Ordinateur',
            'Mode Home',
            'Mode Feme'
        ];
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}