<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use App\Form\ArticleSearchType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("articles/{category}/{slug}/{id}", name="articles_show", requirements={"slug": "[a-z0-9\-]*"} )
     */
    public function articleshow(Article $article,string $category, string $slug, Request $request): Response
    {
        if($slug !== $article->getSlug() || $category !== $article->getCategory()->getTitle() ){
            return $this->redirectToRoute('articles_show',
                [
                    'category'=>$article->getCategory()->getTitle(),
                    'slug'=>$article->getSlug(),
                    'id'=>$article->getId()
                ],301);
        }
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
        return $this->renderForm('main/article/show.html.twig', [
            'article'=>$article,
            // 'comment' => $comment,
            // 'form' => $form,
        ]);
    }
    /**
     * @Route("/articles", name="articles")
     */
    public function index(Request $request, PaginatorInterface $paginator, ArticleRepository $articleRepository): Response
    {
        $search = new ArticleSearch();
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
        return $this->renderForm('main/article/index.html.twig', [
            'articles' => $pagination,
            'form'=>$form
        ]);
    }
}