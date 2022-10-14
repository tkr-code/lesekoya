<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdresseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adresse = new Adresse();
        $adresse
            ->setLastName('Client1')
            ->setFirstName('Client1')
            ->setCity('Dakar')
            ->setRue('Sacre coeur')
            ->setTel('781278288')
            ->setPays('Senegal')
            ->setCodePostal('11000')
        ;
        $this->addReference('adresse_client_1',$adresse);
        $manager->persist($adresse);
        $manager->flush();
    }
}
