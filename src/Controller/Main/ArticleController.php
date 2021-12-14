<?php

namespace App\Controller\Main;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ParentCategoryRepository;
use Cocur\Slugify\Slugify;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("boutique/{category}/{slug}/{id}", name="articles_show", requirements={"slug": "[a-z0-9\-]*"} )
     */
    public function show(Article $article,string $category, string $slug, Request $request, ArticleRepository $articleRepository): Response
    {
        if($slug !== $article->getSlug() || $category !== $article->getCategory()->getTitle() ){
            return $this->redirectToRoute('articles_show',
                [
                    'category'=>$article->getCategory()->getTitle(),
                    'slug'=>$article->getSlug(),
                    'id'=>$article->getId()
                ],301);
        }
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        // $comment = new Comment();
        // $comment->setProduit($produit);
        
        // $comment->setAdmin($this->getUser());
        // $form = $this->createForm(CommentType::class, $comment);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($comment);
        //     $entityManager->flush();
        //     $this->addFlash('success','Commentaire enregistré');
        //     return $this->redirectToRoute('articles_show',
        //         [
        //             'category'=>$category,
        //             'slug'=>$slug,
        //             'id'=>$produit->getId()
        //         ], Response::HTTP_SEE_OTHER);
        // }
        return $this->renderForm('leSekoya/shop/show.html.twig', [
            'article'=>$article,
            'articles'=>$articleRepository->findBy(['enabled'=>true,'etat'=>'top'],null,12),
            'form' => $form,
        ]);
    }
    /**
     * @Route("/boutique", name="articles")
     * @Route("/boutique/{parent}", name="articles_parent")
     * @Route("/boutique/{parent}/{category}", name="articles_category")
     */
    public function index(string $parent = null, string $category = null, ParentCategoryRepository $parentCategoryRepository, Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $category = str_replace('-',' ',$category);
        $search = new ArticleSearch();
        $search->setCategory($category);
        $form = $this->createForm(ArticleSearchType::class,$search)->handleRequest($request);
        $pagination = $paginator->paginate(
            $articleRepository->search(
                $search->getMots(),
                $search->getCategory(),
                $search->getMinPrice(),
                $search->getMaxPrice()
            ),
            $request->query->getInt('page',1),
            12
        );
        // return $this->renderForm('main/article/index_1.html.twig', [
        // return $this->renderForm('main/article/index.html.twig', [
            // dd($categoryRepository->parents());
        return $this->renderForm('leSekoya/shop/index.html.twig', [
            'articles' => $pagination,
            'form'=>$form,
            'breadcrumb'=>[
                'parent'=>ucfirst($parent),
                'category'=>ucfirst($category)
            ],
            'category'=>$categoryRepository->findAll(),
            'category_parents'=>$parentCategoryRepository->etat(true),
            'top_articles'=>$articleRepository->findBy(['enabled'=>true,'etat'=>'top'],null,12),
        ]);
    }

    /**
     * @Route("/suggestion/", name="suggestions")
     */
    public function suggestion($mots, ArticleRepository $articleRepository)
    {
       $search = $articleRepository->searchJson($mots);
        // dd($search);
        return $this->json(
            [
                'suggests'=>[ $search ]
            ]
        );
    }
}