<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Personne;
use App\Entity\User;
use App\Service\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $em;
    private $passwordEncoder;
    private $service;
    public function __construct(Service $service, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->service = $service;
        $this->em = $entityManagerInterface;
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {

        $admin = [
            ['first_name' => 'Admin','last_name' => 'Admin','email' => 'admin@store.com','roles' => ["ROLE_ADMIN"]],
        ];
        foreach ($admin as $key => $value) {
            $user = new User();
            $user->setFirstName($value['first_name'])
            ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setStatus('Activer');
            $user->setIsVerified(true);
            $user->setCle($this->service->aleatoire(100));
            $user->setPhoneNumber('770000000');
            $user->setPassword($this->passwordEncoder->hashPassword($user,'password'))
            ->setRoles($value['roles']);
            $this->em->persist($user);
            $this->addReference('user_'.$value['email'],$user);
        }

        $clients = [
            [
                'first_name' => 'Malick',
                'last_name' => 'Tounkara',
                'email' => 'client@store.com',
                'roles' => ["ROLE_CLIENT"]
            ],
        ];
        foreach ($clients as $key => $value) {
            $client  = new Client();
            $user = new User();
            $user->setFirstName($value['first_name'])
            ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setStatus('Activer');
            $user->setIsVerified(true);
            $user->setCle($this->service->aleatoire(100));
            $user->setPhoneNumber('770000000');
            $user->setPassword($this->passwordEncoder->hashPassword($user,'password'))
            ->setRoles($value['roles']);
            $user->setClient($client);
            $this->em->persist($user);
            $this->addReference('client_'.$value['email'],$user);
        }
        $this->em->flush();
    }
}