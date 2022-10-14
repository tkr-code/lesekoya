<?php 
namespace App\Twig;

use App\Repository\ParentCategoryRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryParentExtention extends AbstractExtension
{
    private $parentCategoryRepository;
    public function __construct(ParentCategoryRepository $parentCategoryRepository)
    {
        $this->parentCategoryRepository = $parentCategoryRepository;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'parentCategorys'])
        ];
    }

    public function all()
    {
        return $this->parentCategoryRepository->etat(true);
        
    }
   
}