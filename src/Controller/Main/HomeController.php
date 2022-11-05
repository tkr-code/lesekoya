<?php

namespace App\Controller\Main;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Repository\Category3Repository;
use App\Repository\CategoryRepository;
use App\Repository\ClientRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/",  name="home")
     */
    public function home(Request $request, ArticleRepository $articleRepository, Category3Repository $category3Repository): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search)->handleRequest($request);
      return  $this->renderForm($this->getParameter('template')."/home/index.html.twig", [
            'niveau3'=>$category3Repository->findAll(),
            'form'=>$form,
            'slide2'=>$articleRepository->findOneBy([
                'title'=>'Hp elitebook Folio G1'
            ]),
            'articles'=>
            [
                'ordinateurs'=>$articleRepository->findCategoryTitle('ordinateur portable','Meilleurs ventes'),
                'cle_usb'=>$articleRepository->findCategoryTitle('clé usb','Meilleurs ventes'),
                'claviers_souris'=>$articleRepository->findCategoryTitle('claviers et souris','Meilleurs ventes'),
                'imprimante_accessoires'=>$articleRepository->findCategoryTitle('imprimante et accessoires','Meilleurs ventes'),
                'tendances'=>$articleRepository->findBy([
                    'etat'=>'Tendance',
                    'enabled'=>true
                ]),
                'populaires'=>$articleRepository->findBy(
                    [
                    'etat'=>'Populaire',
                    'enabled'=>true
                    ],null,15
                )
            ]
        ]);
    }
    /**
     * @Route("/test",  name="test")
     */
    public function test(UserRepository $userRepository, ArticleRepository $articleRepository): Response
    {   
        $article = $articleRepository->find(66);
        dump(
            $articleRepository->isFavoris($this->getUser(),$article)
        );
        return dd('');
    }
}