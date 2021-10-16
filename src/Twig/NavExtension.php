<?php 
namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtension extends AbstractExtension
{
    const icon ='far fa-circle';
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
            'user'=>
            [
                [
                    'name'=>'LeSekoya',
                    'links'=>
                        [
                            [
                                'name'=>'Home',
                                'path'=>'home'
                            ],
                            [
                                'name'=>'Articles',
                                'path'=>'articles'
                            ],
                            [
                                'name'=>'contact',
                                'path'=>'contact'
                            ],
                            [
                                'name'=>'panier',
                                'path'=>'cart_index'
                            ]
                        ]
                ],
                [
                    'name'=>'Produit',
                    'path'=>'article_index',
                    'icon'=>'fab fa-product-hunt',
                    'links'=>
                        [
                            [
                                'name'=>'Produits',
                                'path'=>'article_index',
                            ],
                            [
                                'name'=>'New Article',
                                'path'=>'article_new',
                                'icon'=>'fas fa-shopping-bag'
                            ]
                        ]
                ],
                [
                    'name'=>'Order',
                    'icon'=>'fab fa-first-order',
                    'links'=>
                        [
                            [
                                'name'=>'List',
                                'path'=>'order_index'
                            ],
                            [
                                'name'=>'new Order',
                                'path'=>'order_new'
                            ],
                        ]
                ],
                [
                    'name'=>'Categorie',
                    'icon'=>'fab fa-cuttlefish',
                    'links'=>
                        [
                            [
                                'name'=>'List',
                                'path'=>'category_index'
                            ],
                            [
                                'name'=>'new Category',
                                'path'=>'category_new'
                            ]
                        ]
                ],
            ],
            'admin'=>
            [
                [
                    'name'=>'user',
                    'path'=>'user_index',
                    'icon'=>'fas fa-users',
                    
                ],
                [
                    'name'=>'pays',
                    'path'=>'user_index',
                    'icon'=>self::icon
                ],
                [
                    'name'=>'Ville',
                    'path'=>'user_index',
                    'icon'=>self::icon
                ],
                [
                    'name'=>'pays',
                    'path'=>'user_index',
                    'icon'=>self::icon
                ],
            ],
            'dashboard'=>
            [
                [
                    'name'=>'Dashbord 1',
                    'path'=>'admin',
                    'icon'=>self::icon
                ],
                [
                    'name'=>'Profil',
                    'path'=>'profile_index',
                    'icon'=>self::icon
                ]
            ],
            'editor'=>
            [
                [
                    'title'=>'Category',
                    'path'=>'category_index',
                    'icon'=>'far fa-circle'
                ]
            ]
        ];
    }
}