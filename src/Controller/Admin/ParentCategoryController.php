<?php

namespace App\Controller\Admin;

use App\Entity\ParentCategory;
use App\Form\ParentCategoryType;
use App\Repository\ParentCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/parent/category")
 */
class ParentCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_parent_category_index", methods={"GET"})
     */
    public function index(ParentCategoryRepository $parentCategoryRepository): Response
    {
        return $this->render('admin/parent_category/index.html.twig', [
            'parent_categories' => $parentCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_parent_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentCategory = new ParentCategory();
        $form = $this->createForm(ParentCategoryType::class, $parentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentCategory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_parent_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/parent_category/new.html.twig', [
            'parent_category' => $parentCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_parent_category_show", methods={"GET"})
     */
    public function show(ParentCategory $parentCategory): Response
    {
        return $this->render('admin/parent_category/show.html.twig', [
            'parent_category' => $parentCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_parent_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ParentCategory $parentCategory): Response
    {
        $form = $this->createForm(ParentCategoryType::class, $parentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_parent_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/parent_category/edit.html.twig', [
            'parent_category' => $parentCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_parent_category_delete", methods={"POST"})
     */
    public function delete(Request $request, ParentCategory $parentCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_parent_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
