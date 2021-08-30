<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Repository\ClientRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;

class MainController extends AbstractController
{
    /**
     * @Route("/change-lang/{locale}", name="lang")
     */
    public function changeLocale($locale, Request $request)
    {
    
        $locale = $request->attributes->get('locale');
        
        $request->getSession()->set('_locale', $locale);
        
        $request->setLocale($request->getSession()->get('_locale', $locale));    
        
        return $this->redirect($request->headers->get('referer'));
    }
    /**
     * @Route("/",  name="home"
     * )
     */
    public function home(Request $request): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search)->handleRequest($request);
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

    //   return  $this->render("main/index_1.html.twig", [
      return  $this->renderForm("main/home/index.html.twig", [
            'pages'=>$pages,
            'searchForm'=>$form

        ]);
    }
}