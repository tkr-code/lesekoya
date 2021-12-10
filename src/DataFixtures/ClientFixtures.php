<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct( UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
       $clients=
        [
            [

               'first_name' => 'Pepin','last_name' => 'Ngoulou',
               'email' => 'client1@mail.com','roles' => ["ROLE_CLIENT"],
               'password' => 'clientstore','is_verified' => '1'
            ],
            [

               'first_name' => 'Mamadou','last_name' => 'Dieme',
               'email' => 'client2@mail.com','roles' => ["ROLE_CLIENT"],
               'password' => 'clientstore','is_verified' => '0'
            ],
            
        ];
        foreach ($clients as $value) {
            $user = new User();
            $user->isVerified(true);
            $personne = new Personne();
            $personne->setFirstName($value['first_name'])
            ->setLastName($value['last_name']);
            $user->setPhoneNumber('781278288')
            ->setAdresse('Sacre coeur 2, 11000');
            $user->setEmail($value['email']);
            $user->setPassword($this->passwordEncoder->hashPassword($user,'password'))
            ->setRoles($value['roles'])
            ->setPersonne($personne);
            $client = new Client();
            $this->addReference('client_'.$value['email'],$user);
            // $client->setUser($this->getReference('client_'.$value['email']));
            $user->setClient($client);
            $manager->persist($user);
        }

        $manager->flush();
    }
}