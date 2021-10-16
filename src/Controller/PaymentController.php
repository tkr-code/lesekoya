<?php

namespace App\Controller;

use App\Entity\ArticleBuy;
use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/", name="payment_index", methods={"GET"})
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('admin/payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/payment/new.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payment_show", methods={"GET"})
     */
    public function show(Payment $payment): Response
    {
        return $this->render('admin/payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payment $payment): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($payment->getState() == 'completed')
            {
                $enntyManager = $this->getDoctrine()->getManager();
                //on creer les achats
                $order = $payment->getOrderPayment();
            
                if($order->getIsImmuable())
                {
                    $client = $order->getUser()->getClient();
                    foreach ($order->getOrderItem() as $key => $value) {
                        $ArticleBuy = new ArticleBuy();
                        $ArticleBuy->setPrice($value->getUnitPrice());
                        $ArticleBuy->setQuantity($value->getQuantity());
                        $ArticleBuy->setArticle($value->getArticle());
                        $ArticleBuy->setClient($client);
                        
                        $enntyManager->persist($ArticleBuy);
                    }
                    $order->setIsImmuable(false);
                    $order->setState('completed');
                }
                //on modifie le status de la commande
                //on met a jour le stock reel
                //on envoie en email de confirmation de reception
                // dd($order);
            }
            // dd($payment);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Payment updated');
            return $this->redirectToRoute('order_edit', ['id'=>$payment->getOrderPayment()->getId(),'tab'=>'facturation'], Response::HTTP_SEE_OTHER);
            // return $this->redirectToRoute('payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/payment/edit.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payment_delete", methods={"POST"})
     */
    public function delete(Request $request, Payment $payment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_index', [], Response::HTTP_SEE_OTHER);
    }
}