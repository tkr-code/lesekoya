<?php 
namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtension extends AbstractExtension
{
    const icon ='far fa-circle';
    private $urlGenerator;
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    public function getFunctions():array
    {
        return[
            new TwigFunction('sidebar',[$this,'getNavs'])
        ];
    }

    public function getNavs()
    {
        return 
        [
            'admin'=>
            [
                [
                    'title'=>'user',
                    'path'=>$this->urlGenerator->generate('user_index'),
                    'icon'=>'fas fa-users'
                ]
            ],
            'editor'=>
            [
                [
                    'title'=>'customer',
                    'path'=>$this->urlGenerator->generate('admin_client_index'),
                    'icon'=>'far fa-circle'
                ],
                [
                    'title'=>'article',
                    'path'=>$this->urlGenerator->generate('article_index'),
                    'icon'=> self::icon
                ],
                [
                    'title'=>'category',
                    'path'=>$this->urlGenerator->generate('category_index'),
                    'icon'=>'far fa-circle'
                ],
                [
                    'title'=>'order',
                    'path'=>$this->urlGenerator->generate('order_index'),
                    'icon'=>'far fa-circle'
                ],
            ]
        ];
    }
}