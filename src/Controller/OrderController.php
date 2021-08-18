<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderItem;
use App\Form\OrderNewType;
use App\Form\OrderItemType;
use App\Repository\OrderRepository;
use App\Service\Order\OrderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'nbrOrders'=>count($orderRepository->findAll()),
            'orders'=>$orderRepository->findAll(),
            'ordersCompleted'=>$orderRepository->findState('completed'),
            'ordersInProgress'=>$orderRepository->findState('in progress'),
            'ordersWaiting'=>$orderRepository->findState('waiting')
        ]);
    }

    /**
     * @Route("/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderNewType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success','Order created');
            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        // dd($order);
        dump($order);
    //    $var =  sprintf("%06s", 1);
        // $ribbon_text = ($order->getState() == 'paid') ? 'PAID':'NOT PAID';

        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/print/{id}", name="order_print", methods={"GET"})
     */
    public function invoice(Order $order): Response
    {
        dump($order);
        return $this->render('admin/order/print.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order, OrderService $orderService): Response
    {
        // dd($order->getOrderItem());
       //Debut new orderItem 
        $orderItem = new OrderItem();
        $formItem = $this->createForm(OrderItemType::class, $orderItem);
        $formItem->handleRequest($request);

        if ($formItem->isSubmitted() && $formItem->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //add order item 
            $orderItem = $orderService->orderItemAdd($orderItem, $order);
            
            $order->setItemsTotal($orderService->subTotal($order));
            
            $entityManager->persist($orderItem,$order);
            $entityManager->flush();
            $this->addFlash('success',"Ordert item add");

            return $this->redirectToRoute('order_edit', ['id'=>$order->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);
        }
        //end new orderItem
        
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Order modified');
            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
        }
        dump($orderService->total($order));

        return $this->renderForm('admin/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
            'formItem' => $formItem,
        ]);
    }

    /**
     * @Route("/{id}", name="order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
    }
}