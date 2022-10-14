<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleBuyRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{

    /**
     * @Route("/load-comment/{id}", name="comment_load_form", methods={"POST","GET"})
     */
    public function loadComment(Comment $comment): Response
    {
        return new JsonResponse([
            'reponse'=>true,
            'content'=>$this->render('lest/shop/_form_comment.html.twig',['comment'=>$comment])->getContent()]);
        return new JsonResponse(['reponse'=>false]);
    }
    /**
     * @Route("/load/{id}", name="comment_load", methods={"POST"})
     */
    public function load(Article $article, ArticleBuyRepository $articleBuyRepository, CommentRepository $commentRepository): Response
    {
        $user = $this->getUser();

        $isBuy = $isComment = false;
        if($user){
            $client = $user->getClient();
            if($client)
            {               
                $isBuy = $articleBuyRepository->isBuy($client,$article);
            }
            $isComment = $commentRepository->isComment($user,$article);
        }

        return new JsonResponse(['content'=>$this->render('lest/shop/_comment.html.twig',[
            'is_buy'=>$isBuy,
            'is_comment'=>$isComment,
            'article'=>$article,
        ])->getContent()]);
    }
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit-js", name="comment_edit_js", methods={"POST"})
     */
    public function editJs(Request $request, Comment $comment): Response
    {
        if($request->request->get('rating') && $request->request->get('content') ){

            $comment->setRating($request->request->get('rating'));
            $comment->setContent($request->request->get('content'));
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse(true);
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="comment_delete", methods={"POST"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
