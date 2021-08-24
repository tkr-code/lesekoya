<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET|POST"})
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success','La catégorie a été créé. ');
            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        $breadcrumb = [
            [
                'path'=>'category_index',
                'name'=>'Gerer les categories'
            ]
        ];
        return $this->renderForm('admin/category/new.html.twig', [
            'pageName'=>'Create Catgeorie',
            'breadcrumb'=>$breadcrumb,
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Modified article');
            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }

        // $breadcrumb = [];
        // return $this->renderForm('admin/category/edit.html.twig', [
        //     'breadcrumb'=>$breadcrumb,
        //     'category' => $category,
        //     'form' => $form,
        // ]);
        return $this->json(['code'=>200,'form'=>$form->createView()],200);

    }
    /**
     * @Route("/{id}/edit/js", name="category_edit_js", methods={"GET","POST"})
     */
    public function editJs(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $this->getDoctrine()->getManager()->flush();
        //     $this->addFlash('success','Modified article');
        //     return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        // }

        // $breadcrumb = [];
        // return $this->renderForm('admin/category/edit.html.twig', [
        //     'breadcrumb'=>$breadcrumb,
        //     'category' => $category,
        //     'form' => $form,
        // ]);
        return $this->json(
            [
                'code'=>200,
                'category'=> $category 
            ],
            200);

    }

    /**
     * @Route("/{id}", name="category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
            $this->addFlash('success','The category has been deleted');
        }
        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/ajax", name="edit_ajax")
     */
    public function ajaxTest():Response
    {
        return $this->json(['code'=>200,'message'=>'ca marche bien'],200);
    }
}