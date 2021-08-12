<?php 
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtension extends AbstractExtension
{
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'getNavs'])
        ];
    }
    public function getNavs(){
        return [
            [
                'name'=>'Category',
                'path'=>'category_index',
                'icon'=>'fas fa home'
            ]
        ];
    }
}