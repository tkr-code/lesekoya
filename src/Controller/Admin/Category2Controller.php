<?php

namespace App\Controller\Admin;

use App\Entity\Category2;
use App\Form\Category2Type;
use App\Repository\Category2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/my-account/category-niveau-2")
 */
class Category2Controller extends AbstractController
{
    /**
     * @Route("/", name="admin_category2_index", methods={"GET"})
     */
    public function index(Category2Repository $category2Repository): Response
    {
        return $this->render('admin/category2/index.html.twig', [
            'category2s' => $category2Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_category2_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Category2Repository $category2Repository): Response
    {
        $category2 = new Category2();
        $form = $this->createForm(Category2Type::class, $category2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category2Repository->add($category2, true);

            return $this->redirectToRoute('admin_category2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category2/new.html.twig', [
            'category2' => $category2,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_category2_show", methods={"GET"})
     */
    public function show(Category2 $category2): Response
    {
        return $this->render('admin/category2/show.html.twig', [
            'category2' => $category2,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_category2_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category2 $category2, Category2Repository $category2Repository): Response
    {
        $form = $this->createForm(Category2Type::class, $category2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category2Repository->add($category2, true);

            return $this->redirectToRoute('admin_category2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category2/edit.html.twig', [
            'category2' => $category2,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_category2_delete", methods={"POST"})
     */
    public function delete(Request $request, Category2 $category2, Category2Repository $category2Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category2->getId(), $request->request->get('_token'))) {
            $category2Repository->remove($category2, true);
        }

        return $this->redirectToRoute('admin_category2_index', [], Response::HTTP_SEE_OTHER);
    }
}
