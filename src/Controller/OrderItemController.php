<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Form\OrderItemType;
use App\Form\OrderItemEditType;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Service\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderItemController extends AbstractController
{
    /**
     * @Route("/admin/order-item/", name="order_item_index", methods={"GET"})
     */
    public function index(OrderItemRepository $orderItemRepository): Response
    {
        return $this->render('admin/order_item/index.html.twig', [
            'order_items' => $orderItemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/order-item/new", name="order_item_new", methods={"GET","POST"})
     */
    public function new(Request $request, OrderService $orderService, OrderRepository $orderRepository ): Response
    {
        $orderItem = new OrderItem();
        $form = $this->createForm(OrderItemType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $order = $orderItem->getCommande();
            $orderService->orderItemAdd($orderItem,$order);
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
     * @Route("/admin/order-item/{id}", name="order_item_show", methods={"GET"})
     */
    public function show(OrderItem $orderItem): Response
    {
        return $this->render('admin/order_item/show.html.twig', [
            'order_item' => $orderItem,
        ]);
    }

        /**
     * @Route("/editor/order-item/{id}/edit/get", name="editor_order_item_edit_get", methods={"GET","POST"})
     *
     */
    public function editOrdeGet(OrderItem $orderItem, Request $request){

        if ($request->request->get('modal') && $request->request->get('modal') == 'qty') {
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_form_order_item_qty.html.twig',[
                    'orderItem'=>$orderItem
                    ])->getContent()
            ]);
        }
        
        return new JsonResponse([
            'reponse'=>false,
        ]);
    }

    /**
     * @Route("/editor/order-item/{id}/edit", name="editor_order_item_edit", methods={"GET","POST"})
     */
    public function editQty(Request $request, OrderItem $orderItem, OrderService $orderService): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if($request->request->get('qty')){
            $orderItem->setQuantity($request->request->get('qty'));
            $orderItem->setUnitsTotal($orderService->subTotatlItem($orderItem));
            $orderService->calculOrder($orderItem->getCommande());
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return new JsonResponse(false);
    }
    /**
     * @Route("/admin/order-item/article-{article_id}/{id}/edit", name="order_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderItem $orderItem, OrderService $orderService): Response
    {
        $form = $this->createForm(OrderItemEditType::class, $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Quantity modify');
            return $this->redirectToRoute('order_edit', ['id'=>$orderItem->getCommande()->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/order_item/edit.html.twig', [
            'order_item' => $orderItem,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/order-item/{id}", name="order_item_delete", methods={"POST"})
     */
    public function delete(Request $request, OrderItem $orderItem, OrderService $orderService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderItem);
            $entityManager->flush();
            $orderService->calculOrder($orderItem->getCommande());
            if($request->request->get('ajax')){
                return New JsonResponse(true);
            }
            $this->addFlash('success','Order item deleted');
        }
        $order = $orderItem->getCommande();
        return $this->redirectToRoute('order_edit', ['id'=>$order->getId()], Response::HTTP_SEE_OTHER);
        // return $this->redirectToRoute('order_item_index', [], Response::HTTP_SEE_OTHER);
    }
}