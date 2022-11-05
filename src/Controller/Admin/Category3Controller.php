<?php

namespace App\Controller\Admin;

use App\Entity\Category3;
use App\Form\Category3Type;
use App\Repository\Category3Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my-account/category-niveau-3")
 */
class Category3Controller extends AbstractController
{
    /**
     * @Route("/", name="admin_category3_index", methods={"GET"})
     */
    public function index(Category3Repository $category3Repository): Response
    {
        return $this->render('admin/category3/index.html.twig', [
            'category3s' => $category3Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_category3_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Category3Repository $category3Repository): Response
    {
        $category3 = new Category3();
        $form = $this->createForm(Category3Type::class, $category3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category3Repository->add($category3, true);

            return $this->redirectToRoute('admin_category3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category3/new.html.twig', [
            'category3' => $category3,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_category3_show", methods={"GET"})
     */
    public function show(Category3 $category3): Response
    {
        return $this->render('admin/category3/show.html.twig', [
            'category3' => $category3,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_category3_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category3 $category3, Category3Repository $category3Repository): Response
    {
        $form = $this->createForm(Category3Type::class, $category3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category3Repository->add($category3, true);

            return $this->redirectToRoute('admin_category3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category3/edit.html.twig', [
            'category3' => $category3,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_category3_delete", methods={"POST"})
     */
    public function delete(Request $request, Category3 $category3, Category3Repository $category3Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category3->getId(), $request->request->get('_token'))) {
            $category3Repository->remove($category3, true);
        }

        return $this->redirectToRoute('admin_category3_index', [], Response::HTTP_SEE_OTHER);
    }
}
