<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $pages =[
            [
                'path'=>'home',
                'name'=>'Home'
            ],
            [
                'path'=>'articles',
                'name'=>'Tous nos articles'
            ],
            [
                'path'=>'article_index',
                'name'=>'Liste des articles | admin '
            ]
        ];

      return  $this->render("main/index.html.twig", [
            'pages'=>$pages,

        ]);
    }
}