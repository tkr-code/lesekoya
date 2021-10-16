<?php

namespace App\Controller;

use App\Entity\DeliverySpace;
use App\Form\DeliverySpace1Type;
use App\Repository\DeliverySpaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delivery/space")
 */
class DeliverySpaceController extends AbstractController
{
    /**
     * @Route("/", name="delivery_space_index", methods={"GET"})
     */
    public function index(DeliverySpaceRepository $deliverySpaceRepository): Response
    {
        return $this->render('delivery_space/index.html.twig', [
            'delivery_spaces' => $deliverySpaceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="delivery_space_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $deliverySpace = new DeliverySpace();
        $form = $this->createForm(DeliverySpace1Type::class, $deliverySpace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($deliverySpace);
            $entityManager->flush();

            return $this->redirectToRoute('delivery_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('delivery_space/new.html.twig', [
            'delivery_space' => $deliverySpace,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_space_show", methods={"GET"})
     */
    public function show(DeliverySpace $deliverySpace): Response
    {
        return $this->render('delivery_space/show.html.twig', [
            'delivery_space' => $deliverySpace,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_space_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DeliverySpace $deliverySpace): Response
    {
        $form = $this->createForm(DeliverySpace1Type::class, $deliverySpace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_space_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('delivery_space/edit.html.twig', [
            'delivery_space' => $deliverySpace,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_space_delete", methods={"POST"})
     */
    public function delete(Request $request, DeliverySpace $deliverySpace): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deliverySpace->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($deliverySpace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('delivery_space_index', [], Response::HTTP_SEE_OTHER);
    }
}
