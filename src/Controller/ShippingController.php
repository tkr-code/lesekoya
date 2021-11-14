<?php

namespace App\Controller;

use App\Entity\Shipping;
use App\Form\ShippingType;
use App\Repository\ShippingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/shipping")
 */
class ShippingController extends AbstractController
{
    /**
     * @Route("/", name="shipping_index", methods={"GET"})
     */
    public function index(ShippingRepository $shippingRepository): Response
    {
        return $this->render('admin/shipping/index.html.twig', [
            'shippings' => $shippingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shipping_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shipping = new Shipping();
        $form = $this->createForm(ShippingType::class, $shipping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shipping);
            $entityManager->flush();

            return $this->redirectToRoute('shipping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/shipping/new.html.twig', [
            'shipping' => $shipping,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shipping_show", methods={"GET"})
     */
    public function show(Shipping $shipping): Response
    {
        return $this->render('admin/shipping/show.html.twig', [
            'shipping' => $shipping,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shipping_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Shipping $shipping): Response
    {
        $form = $this->createForm(ShippingType::class, $shipping);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shipping_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/shipping/edit.html.twig', [
            'shipping' => $shipping,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shipping_delete", methods={"POST"})
     */
    public function delete(Request $request, Shipping $shipping): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shipping->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shipping);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shipping_index', [], Response::HTTP_SEE_OTHER);
    }
}
