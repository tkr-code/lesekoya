<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderItem;
use App\Entity\Payment;
use App\Form\PaymentType;
use App\Form\OrderNewType;
use App\Form\OrderItemType;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use App\Service\Order\OrderService;
use App\Service\Payment\PaymentService;
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
    public function new(Request $request, OrderService $orderService): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderNewType::class, $order);
        $form->handleRequest($request);
        
         

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $order = $orderService->calculPersist($order);
            $entityManager->persist($order);
            $entityManager->flush();
            $this->addFlash('success','Order created');
            // dd($order);
            return $this->redirectToRoute('order_edit', ['id'=>$order->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Order $order, OrderItemRepository $orderItemRepository,  OrderService $orderService, PaymentService $paymentService): Response
    {
        $message = '';
        // debut payment
        $payment = $order->getPayment();
        $formPayment = $this->createForm(PaymentType::class, $payment);
        $formPayment->handleRequest($request);
        //en payment
       //Debut new orderItem 
        $orderItem = new OrderItem();
        $formItem = $this->createForm(OrderItemType::class, $orderItem);
        $formItem->handleRequest($request);
        // dump($order->getOrderItem()->getValues());
        if ($formItem->isSubmitted() && $formItem->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //add order item 
            $orderService->orderItemAdd($orderItem, $order);
            
            $order->setItemsTotal($orderService->subTotal($order));
            

            $orderItemPost =  $orderItemRepository->findOneBy([
                        'produit_name'=>$orderItem->getArticle()->getTitle(),
                        'commande'=>$order->getId()
            ]);

            if(!$orderItemPost){
                $entityManager->persist($orderItem,$order);
                $message = 'Order item  add';
                $entityManager->flush();
                $this->addFlash('success',$message);
                return $this->redirectToRoute('order_edit', ['id'=>$order->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);       
            }
            $message = "Article existe dans la commande ";
            $this->addFlash('warning',$message);
            
        }
        //end new orderItem
        
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {            
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('order_index', [], Response::HTTP_SEE_OTHER);
            $this->addFlash('success','Order modified');
        }
        
        $orderService->calculOrder($order);

        $payment = $order->getPayment();
        $payment->setAmount($order->getTotal());

        $paymentService->calculPayment($payment);
        $order->setPayment($payment);
        
        dump($order);
        return $this->renderForm('admin/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
            'formItem' => $formItem,
            'formFacturation'=>$formPayment
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