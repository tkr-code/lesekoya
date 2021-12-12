<?php 
namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class NavExtension extends AbstractExtension
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
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
            'client'=>
            [
                
            ],
            'user'=>
            [

                [
                    'name'=>'Client',
                    'links'=>[
                        [
                            'name'=>'Clients',
                            'path'=>'admin_client_index'
                        ],
                        // [
                        //     'name'=>'Nouveau client',
                        //     'path'=>'client_new'
                        // ],
                    ]
                ],
                [
                    'name'=>'Produit',
                    'path'=>'article_index',
                    'links'=>
                        [
                            [
                                'name'=>'Produits',
                                'path'=>'article_index',
                            ],
                            [
                                'name'=>'New Produit',
                                'path'=>'article_new',
                            ]
                        ]
                ],
                [
                    'name'=>'Commande',
                    'icon'=>'fa fa-shopping-bag',
                    'links'=>
                        [
                            [
                                'name'=>'Commandes',
                                'path'=>'order_index'
                            ],
                            [
                                'name'=>'new Order',
                                'path'=>'order_new'
                            ],
                        ]
                ],
            ],
            'admin'=>
            [
                [
                    'name'=>'Categorie',
                    'links'=>
                        [
                            [
                                'name'=>'Parent',
                                'path'=>'admin_parent_category_index'
                            ],
                            [
                                'name'=>'Categories',
                                'path'=>'category_index'
                            ],
                            [
                                'name'=>'new Category',
                                'path'=>'category_new'
                            ]
                        ]
                ],
                [
                    'name'=>'user',
                    'icon'=>'fas fa-users',
                    'links'=>[
                        [
                            'name'=>'Users',
                            'path'=>'user_index',
                        ],
                        [
                            'name'=>'new User',
                            'path'=>'user_new',
                        ],
                    ]
                    
                ],
                [
                    'name'=>'Gestion',
                    'icon'=>'fas fa-cogs',
                    'links'=>[
                        [
                            'name'=>'pays',
                            'path'=>'home',
                        ],
                        [
                            'name'=>'Rue',
                            'path'=>'street_index'
                        ],
                        [
                            'name'=>'Lieu de livraison',
                            'path'=>'admin_delivery_space_index'
                        ]       
                    ]
                ]
            ],
            'dashboard'=>
            [
                [
                    'name'=>$this->translator->trans('Dashboard'),
                    'icon'=>'fas fa-tachometer-alt',
                    'links'=>[
                        [
                            'name'=>$this->translator->trans('Dashboard').' 1',
                            'path'=>'admin'
                        ]
                    ]
                ],
                [
                    'name'=>'Profil',
                    'path'=>'profile_index',
                    'icon'=>'fas fa-user'
                ],
                [
                    'name'=>'LeSekoya',
                    'icon'=>'fa fa-home',
                    'links'=>
                        [
                            [
                                'name'=>$this->translator->trans('Home'),
                                'path'=>'home'
                            ],
                            [
                                'name'=>'Produits',
                                'path'=>'articles'
                            ],
                            [
                                'name'=>'Contact',
                                'path'=>'contact'
                            ],
                            [
                                'name'=>$this->translator->trans('cart'),
                                'path'=>'cart_index'
                            ]
                        ]
                ],
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