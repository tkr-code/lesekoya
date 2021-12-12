<?php

namespace App\Controller\Main;

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

class HomeController extends AbstractController
{
    /**
     * @Route("/",  name="home")
     */
    public function home(Request $request, ArticleRepository $articleRepository): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search)->handleRequest($request);
      return  $this->renderForm("leSekoya/home/index.html.twig", [
            'form'=>$form,
            'articles'=>[
                'rand'=>$articleRepository->findRand(),
                'tendances'=>$articleRepository->findBy([
                    'etat'=>'Tendance',
                    'enabled'=>true
                ]),
                'top'=>$articleRepository->findBy([
                    'etat'=>'Top',
                    'enabled'=>true
                ])
            ]
        ]);
    }
}