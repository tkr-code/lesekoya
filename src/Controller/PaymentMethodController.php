<?php

namespace App\Controller;

use App\Entity\PaymentMethod;
use App\Form\PaymentMethodType;
use App\Repository\PaymentMethodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment/method")
 */
class PaymentMethodController extends AbstractController
{
    /**
     * @Route("/", name="payment_method_index", methods={"GET"})
     */
    public function index(PaymentMethodRepository $paymentMethodRepository): Response
    {
        return $this->render('payment_method/index.html.twig', [
            'payment_methods' => $paymentMethodRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_method_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paymentMethod = new PaymentMethod();
        $form = $this->createForm(PaymentMethodType::class, $paymentMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentMethod);
            $entityManager->flush();

            return $this->redirectToRoute('payment_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment_method/new.html.twig', [
            'payment_method' => $paymentMethod,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payment_method_show", methods={"GET"})
     */
    public function show(PaymentMethod $paymentMethod): Response
    {
        return $this->render('payment_method/show.html.twig', [
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_method_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaymentMethod $paymentMethod): Response
    {
        $form = $this->createForm(PaymentMethodType::class, $paymentMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment_method/edit.html.twig', [
            'payment_method' => $paymentMethod,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payment_method_delete", methods={"POST"})
     */
    public function delete(Request $request, PaymentMethod $paymentMethod): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentMethod->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_method_index', [], Response::HTTP_SEE_OTHER);
    }
}
