<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brands =[
            'Hp','Dell','Lenovo','Toshiba','Asus','Acer','Apple','Microsoft','Razer','Huawei','Alienware',
            'MSI','Samsung','Imation','Sandisk'
        ];
        foreach ($brands as $key => $value) {
            $brand = new Brand();
            $brand
            ->setName($value)
            // ->addArticle($this->getReference('_article_Hp_probook'))
            // ->addCategory($this->getReference('category_Ordinateurs'))
            ;
            $this->addReference('brand_'.$value, $brand);
            $manager->persist($brand);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            CategoryFixtures::class
        ];
    }
}
