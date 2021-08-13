<?php 
namespace App\Service\Card;

class DataCategory extends Data {

    public function category():array
    {
        return 
        [
         'Informatique',
         'Ordinteur',
         'Sac à main',
         'Montre',
         'Scanners',
         'Clavier & souris Pc',
         'Imprimantes',
         'Vêtements'
        ];
    }
}