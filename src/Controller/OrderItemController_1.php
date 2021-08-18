<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Form\OrderItemType;
use App\Repository\OrderItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order/item")
 */
class OrderItemController_1 extends AbstractController
{
    /**
     * @Route("/", name="order_item_index", methods={"GET"})
     */
    public function index(OrderItemRepository $orderItemRepository): Response
    {
        return $this->render('admin/order_item/index.html.twig', [
            'order_items' => $orderItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_item_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderItem = new OrderItem();
        $form = $this->createForm(OrderItemType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderItem);
            $entityManager->flush();

            return $this->redirectToRoute('order_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/order_item/new.html.twig', [
            'order_item' => $orderItem,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="order_item_show", methods={"GET"})
     */
    public function show(OrderItem $orderItem): Response
    {
        return $this->render('admin/order_item/show.html.twig', [
            'order_item' => $orderItem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderItem $orderItem): Response
    {
        $form = $this->createForm(OrderItemType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/order_item/edit.html.twig', [
            'order_item' => $orderItem,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="order_item_delete", methods={"POST"})
     */
    public function delete(Request $request, OrderItem $orderItem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderItem);
            $entityManager->flush();
        }
        $order = $orderItem->getCommande();
        $this->addFlash('success','Order item deleted');
        return $this->redirectToRoute('order_edit', ['id'=>$order->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);
        // return $this->redirectToRoute('order_item_index', [], Response::HTTP_SEE_OTHER);
    }
}