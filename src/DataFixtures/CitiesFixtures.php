<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = 
        [
            'Senegal'=>
                [
                    [
                        'Dakar','Tambacounda','Thiès','Diourbel','Fatick','Matam','Saint-Louis',
                        'Kaolack','Kaffrine','Kolda','Sédhiou','Ziguinchor','Kédougou'],
                ],
            'Gabon'=>[
                [
                    'Estuaire','Haut-ogooué','Moyen-Ogooué','Ngounié','Nyanga','Ogooué-Ivindo',
                    'Ogooué-lolo','Ogooué-maritime','Woleu-Ntem'
                ],
            ],
            'Mali'=>[
                ['Kayes','Gao','Kidal','Mopti','Sikasso','Tombouctou','Bamako','Koulikoro','Taoudénit','Ménaka'],
            ]
        ];
        foreach ($data as $key => $value) {
            $country = new Country();
            $country->setName($key);
            foreach ($value as $key => $cities) {
                foreach ($cities as $key => $cityName) {
                    $city = new City();
                    $city->setName($cityName);
                    $country->addCity($city);
                    $this->addReference($cityName,$city);
                }
            }
            $this->addReference($country->getName(),$country);
            $manager->persist($country);
        }
        $manager->flush();
    }
}