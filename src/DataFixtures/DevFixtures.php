<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Article;
use App\Entity\Personne;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DevFixtures extends Fixture
{
    private $em;
    private $passwordEncoder;
    public function __construct(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->em = $entityManagerInterface;
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        
        // for ($i=0; $i < 10; $i++){
        //     $category  = $this->getReference(('category_'.str_replace(' ','_','Ordinateur portable')));
        //     for ($i= 0 ; $i < 100; $i++) {
        //         $detail = isset($value['detail']) ? $value['detail']:'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Recusandae consequatur dicta';
        //     $article  = new Article();
        //     $article->setTitle($value['title'])
        //     ->setCreatedAt(new DateTime())
        //     ->setCategory($category)
        //     ->setBuyingPrice($value['buy'])
        //     ->setPrice($value['price'])
        //     ->setEnabled(true)
        //     ->setEtat($value['etat'])
        //     ->setDescription($detail)
        //     ->setQuantity(10)
        //     ->setStatus('Neuf')
        //     ->setQtyReel(10);
        //     $this->addReference('_article_'. str_replace(' ','_', $value['title']),$article);
        //     $manager->persist($article);
        //     }
        // }

        // $manager->flush();
    }
}
