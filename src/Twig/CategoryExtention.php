<?php 
namespace App\Twig;

use App\Repository\Category2Repository;
use App\Repository\Category3Repository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryExtention extends AbstractExtension
{
    private $categoryRepositoty;
    private $category2Repository;
    private $category3Repository;
    public function __construct(CategoryRepository $categoryRepository,Category3Repository $category3Repository, Category2Repository $category2Repository)
    {
        $this->categoryRepositoty = $categoryRepository;
        $this->category3Repository = $category3Repository;
        $this->category2Repository = $category2Repository;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'categories']),
        ];
    }

    public function filtre3(string $slug){
        return $this->category3Repository->findOneBy([
            'slug'=>$slug
        ]);
    }
    public function filtre2(string $slug = null){
        dump($this->category2Repository->findAll());
        return $this->category2Repository->findAll();
    }

    public function niveau3(){
        return $this->category3Repository->findAll();
    }

    public function all()
    {
        return $this->categoryRepositoty->findAll();
        
    }
   
}