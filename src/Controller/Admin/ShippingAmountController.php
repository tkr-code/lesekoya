<?php

namespace App\Controller\Admin;

use App\Entity\ShippingAmount;
use App\Form\ShippingAmountType;
use App\Repository\ShippingAmountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/shipping/amount")
 */
class ShippingAmountController extends AbstractController
{
    /**
     * @Route("/", name="shipping_amount_index", methods={"GET"})
     */
    public function index(ShippingAmountRepository $shippingAmountRepository): Response
    {
        return $this->render('admin/shipping_amount/index.html.twig', [
            'shipping_amounts' => $shippingAmountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="shipping_amount_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $shippingAmount = new ShippingAmount();
        $form = $this->createForm(ShippingAmountType::class, $shippingAmount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shippingAmount);
            $entityManager->flush();

            return $this->redirectToRoute('shipping_amount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/shipping_amount/new.html.twig', [
            'shipping_amount' => $shippingAmount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shipping_amount_show", methods={"GET"})
     */
    public function show(ShippingAmount $shippingAmount): Response
    {
        return $this->render('admin/shipping_amount/show.html.twig', [
            'shipping_amount' => $shippingAmount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="shipping_amount_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ShippingAmount $shippingAmount): Response
    {
        $form = $this->createForm(ShippingAmountType::class, $shippingAmount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shipping_amount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/shipping_amount/edit.html.twig', [
            'shipping_amount' => $shippingAmount,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="shipping_amount_delete", methods={"POST"})
     */
    public function delete(Request $request, ShippingAmount $shippingAmount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shippingAmount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shippingAmount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shipping_amount_index', [], Response::HTTP_SEE_OTHER);
    }
}
