<?php 
namespace App\Twig;

use Oneup\UploaderBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SearchExtension extends AbstractExtension
{

    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'getForm'])
        ];
    }
    public function getForm(){
        // $form = new Cr
        // $form = new Form()
        return [
            [
                'name'=>'Category',
                'path'=>'category_index',
                'icon'=>'fas fa home'
            ]
        ];
    }
}