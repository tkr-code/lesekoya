<?php

namespace App\Tests;

use App\Entity\City;
use App\Entity\Country;
use PHPUnit\Framework\TestCase;

class UtiTest extends TestCase
{
    public function testSomething(): void
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
                    }
                }
                // dump($country);
                // dump($city);
                // $manager->persist($country);
            }
            // dump($cities);
            // dump($pays);
        $this->assertTrue(true);
    }
}