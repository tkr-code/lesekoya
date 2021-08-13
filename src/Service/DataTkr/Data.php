<?php 
namespace App\Service\Card;

use Faker\Factory;
use App\Entity\Produit;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class Data  {
    private $em;
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }
}