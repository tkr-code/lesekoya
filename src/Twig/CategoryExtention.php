<?php 
namespace App\Twig;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryExtention extends AbstractExtension
{
    private $categoryRepositoty;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepositoty = $categoryRepository;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'categories'])
        ];
    }

    public function all()
    {
        return $this->categoryRepositoty->findAll();
        
    }
   
}