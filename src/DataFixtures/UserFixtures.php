<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
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
        $users = array(
        array('first_name' => 'Malick','last_name' => 'Tounkara','email' => 'admin@mail.com','roles' => ["ROLE_ADMIN","ROLE_EDITOR"],'password' => 'adminstore','is_verified' => '1'),
        array('first_name' => 'Mamadou','last_name' => 'Dieme','email' => 'user1@mail.com','roles' => ["ROLE_EDITOR","ROLE_USER"],'password' => 'userstore','is_verified' => '1'),
        array('first_name' => 'Pepin','last_name' => 'Ngoulou','email' => 'user2@mail.com','roles' => ["ROLE_USER"],'password' => 'userstore','is_verified' => '1'),
        array('first_name' => 'Mariame','last_name' => 'Daffee','email' => 'user3@mail.com','roles' => ["ROLE_USER"],'password' => 'userstore','is_verified' => '1'),
        );
        $adress = array(
            array('id' => '1','first_name' => 'Malick','last_name' => 'Tounkara','phone_number' => '781278288','street' => 'Liberte 4','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-14 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'DK','province_name' => 'Dakar','user_id' => '1'),
            array('id' => '2','first_name' => 'Mamadou','last_name' => 'Dieme','phone_number' => '781278288','street' => 'Mbour','company' => 'PMD developper','city' => 'Mbour','postal_code' => '12000','created_at' => '2021-08-15 10:08:16','updated_at' => '2021-08-20 12:12:12','country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '1'),
            array('id' => '3','first_name' => 'Pepin','last_name' => 'Ngoulou','phone_number' => '781278288','street' => 'Derkle','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-15 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '2'),
            array('id' => '4','first_name' => 'Pepin','last_name' => 'Ngoulou','phone_number' => '781278288','street' => 'Derkle','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-15 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '2'),
            array('id' => '5','first_name' => 'Malick','last_name' => 'Tounkara','phone_number' => '781278288','street' => 'Liberte 4','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-14 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'DK','province_name' => 'Dakar','user_id' => '5'),
            array('id' => '6','first_name' => 'Mamadou','last_name' => 'Dieme','phone_number' => '781278288','street' => 'Mbour','company' => 'PMD developper','city' => 'Mbour','postal_code' => '12000','created_at' => '2021-08-15 10:08:16','updated_at' => '2021-08-20 12:12:12','country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '5'),
            array('id' => '7','first_name' => 'Pepin','last_name' => 'Ngoulou','phone_number' => '781278288','street' => 'Derkle','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-15 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '5'),
            array('id' => '8','first_name' => 'Pepin','last_name' => 'Ngoulou','phone_number' => '781278288','street' => 'Derkle','company' => 'PMD developper','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-15 10:08:16','updated_at' => NULL,'country_code' => 'SN','province_code' => 'MB','province_name' => 'Dakar','user_id' => '5'),
            array('id' => '9','first_name' => 'malick','last_name' => 'tounkara','phone_number' => '781278288','street' => 'liberte 4','company' => 'pmd developer','city' => 'dakar','postal_code' => '110000','created_at' => '2021-08-23 00:07:00','updated_at' => NULL,'country_code' => 'sn','province_code' => 'dkr','province_name' => 'dakar','user_id' => '6'),
            array('id' => '10','first_name' => 'client 4','last_name' => 'name 4','phone_number' => '781258288','street' => 'Wakam','company' => 'pmd developer','city' => 'Dakar','postal_code' => '11000','created_at' => '2021-08-24 15:38:43','updated_at' => NULL,'country_code' => 'SN','province_code' => 'DKR','province_name' => 'Dakar','user_id' => '7'),
            array('id' => '11','first_name' => 'prenom 4','last_name' => 'nom 4','phone_number' => '781278288','street' => 'Sacre coeur','company' => 'pmd developer','city' => 'dakar','postal_code' => '11000','created_at' => '2021-08-25 19:32:16','updated_at' => NULL,'country_code' => 'sn','province_code' => 'dkr','province_name' => 'dakar','user_id' => '8')
        );
        foreach ($users as $key => $value) {
            $user = new User();
            $personne = new Personne();
            $personne->setFirstName($value['first_name'])
            ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setPhoneNumber('781278288')
            ->setAdresse('');
            $user->setPassword($this->passwordEncoder->hashPassword($user,'password'))
            ->setRoles($value['roles'])
            ->setPersonne($personne);
            $this->em->persist($user);

            $this->addReference('user_'.$key,$user);
        }
        $this->em->flush();
    }
}