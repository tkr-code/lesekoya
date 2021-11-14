<?php

namespace App\DataFixtures;

use App\Entity\ParentCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryParent extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Auto & moto');
        $parentCategorie->setIsActive(false);
        $this->addReference('parent_auto_&_moto',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Chaussures');
        $parentCategorie->setIsActive(false);
        $this->addReference('parent_chaussures',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Informatique');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_informatique',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Multimédia');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_multimédia',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Vêtement');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_vêtement',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Maison');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_maison',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Mode');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_mode',$parentCategorie);
        $manager->persist($parentCategorie);

        $parentCategorie = new ParentCategory();
        $parentCategorie->setName('Smartphone');
        $parentCategorie->setIsActive(true);
        $this->addReference('parent_smartphone',$parentCategorie);
        $manager->persist($parentCategorie);

        $manager->flush();
    }
}
