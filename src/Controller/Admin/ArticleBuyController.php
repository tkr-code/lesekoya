<?php

namespace App\Controller\Admin;

use App\Entity\ArticleBuy;
use App\Form\ArticleBuyType;
use App\Repository\ArticleBuyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article/buy")
 */
class ArticleBuyController extends AbstractController
{
    /**
     * @Route("/", name="admin_article_buy_index", methods={"GET"})
     */
    public function index(ArticleBuyRepository $articleBuyRepository): Response
    {
        return $this->render('admin/article_buy/index.html.twig', [
            'article_buys' => $articleBuyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_article_buy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $articleBuy = new ArticleBuy();
        $form = $this->createForm(ArticleBuyType::class, $articleBuy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articleBuy);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_buy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article_buy/new.html.twig', [
            'article_buy' => $articleBuy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_buy_show", methods={"GET"})
     */
    public function show(ArticleBuy $articleBuy): Response
    {
        return $this->render('admin/article_buy/show.html.twig', [
            'article_buy' => $articleBuy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_buy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArticleBuy $articleBuy): Response
    {
        $form = $this->createForm(ArticleBuyType::class, $articleBuy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article_buy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article_buy/edit.html.twig', [
            'article_buy' => $articleBuy,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_buy_delete", methods={"POST"})
     */
    public function delete(Request $request, ArticleBuy $articleBuy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleBuy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($articleBuy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_buy_index', [], Response::HTTP_SEE_OTHER);
    }
}
