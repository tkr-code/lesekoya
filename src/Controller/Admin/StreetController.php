<?php

namespace App\Controller\Admin;

use App\Entity\Street;
use App\Form\StreetType;
use App\Repository\StreetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/street")
 */
class StreetController extends AbstractController
{
    /**
     * @Route("/", name="street_index", methods={"GET"})
     */
    public function index(StreetRepository $streetRepository): Response
    {
        return $this->render('admin/street/index.html.twig', [
            'streets' => $streetRepository->findAll(),
        ]);
    }

    /**
     * @Route("-new", name="street_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $street = new Street();
        $form = $this->createForm(StreetType::class, $street);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($street);
            $entityManager->flush();

            return $this->redirectToRoute('street_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/street/new.html.twig', [
            'street' => $street,
            'form' => $form,
        ]);
    }

    /**
     * @Route("-{id}", name="street_show", methods={"GET"})
     */
    public function show(Street $street): Response
    {
        return $this->render('admin/street/show.html.twig', [
            'street' => $street,
        ]);
    }

    /**
     * @Route("-{id}/edit", name="street_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Street $street): Response
    {
        $form = $this->createForm(StreetType::class, $street);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('street_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/street/edit.html.twig', [
            'street' => $street,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="street_delete", methods={"POST"})
     */
    public function delete(Request $request, Street $street): Response
    {
        if ($this->isCsrfTokenValid('delete'.$street->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($street);
            $entityManager->flush();
        }

        return $this->redirectToRoute('street_index', [], Response::HTTP_SEE_OTHER);
    }
}