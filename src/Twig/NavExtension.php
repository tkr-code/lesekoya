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
    const icon = 'far fa-circle';
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar', [$this, 'getNavs'])
        ];
    }

    public function getNavs()
    {
        return
            [
                'navs' =>
                [
                    [
                        'name' => $this->translator->trans('Dashboard'),
                        'icon' => 'fas fa-tachometer-alt',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Dashboard') . ' 1',
                                'path' => 'admin'
                            ]
                        ]
                    ],
                    [
                        'id' => 'profile',
                        'name' => 'Profile',
                        'icon' => 'fas fa-user',
                        'path' => 'profile_index',
                    ],
                    [
                        'name' => 'Lest',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => $this->translator->trans('Home'),
                                'path' => 'home'
                            ],
                            [
                                'name' => 'Boutique',
                                'path' => 'articles'
                            ],
                            [
                                'name' => 'Contact',
                                'path' => 'contact'
                            ],
                            [
                                'name' => $this->translator->trans('cart'),
                                'path' => 'cart_index'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Client',
                        'path' => 'admin_client_index'
                    ],
                    [
                        'name' => 'Commande',
                        'icon' => 'fa fa-shopping-bag',
                        'links' =>
                        [
                            [
                                'name' => 'Commandes',
                                'path' => 'order_index'
                            ],
                            [
                                'name' => 'new Order',
                                'path' => 'order_new'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Produit',
                        'path' => 'article_index',
                        'links' =>
                        [
                            [
                                'name' => 'Produits',
                                'path' => 'article_index',
                            ],
                            [
                                'name' => 'New Produit',
                                'path' => 'article_new',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Montant de livraison',
                        'path' => 'street_index'
                    ],
                ],
                'admin' =>
                [

                    [
                        'name' => 'Gérant',
                        'icon' => 'fas fa-users',
                        'links' => [
                            [
                                'name' => 'Gérants',
                                'path' => 'gerant_index',
                            ],
                            [
                                'name' => 'Nouveau',
                                'path' => 'gerant_new',
                            ],
                        ]

                    ],
                    [
                        'name' => 'Categorie',
                        'path' => 'category_index',
                        'icon' => 'far fa-circle'
                    ],
                    [
                        'name' => 'Gestion',
                        'icon' => 'fas fa-cogs',
                        'links' => [
                            [
                                'name' => 'pays',
                                'path' => 'home',
                            ],

                            [
                                'name' => 'Lieu de livraison',
                                'path' => 'admin_delivery_space_index'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Marque',
                        'links' => [
                            [
                                'name' => 'Liste',
                                'path' => 'admin_brand_index'
                            ],
                            [
                                'name' => 'new',
                                'path' => 'admin_brand_new',
                            ],

                        ]
                    ],

                ],
                'editor' =>
                []
            ];
    }
}
