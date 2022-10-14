<?php

namespace App\Controller\Admin;

use App\Entity\ArticleBuy;
use App\Entity\DeliverySpace;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderItem;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Form\PaymentType;
use App\Form\OrderNewType;
use App\Form\OrderItemType;
use App\Repository\OrderItemRepository;
use App\Repository\AdressRepository;
use App\Repository\ArticleRepository;
use App\Repository\DeliverySpaceRepository;
use App\Repository\OrderRepository;
use App\Repository\PaymentMethodRepository;
use App\Repository\StreetRepository;
use App\Service\Order\OrderService;
use App\Service\Payment\PaymentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderController extends AbstractController
{
    private $urlGenerator;
    private $parent_page = 'Commande';
    public function __construct(UrlGeneratorInterface $urlGeneratorInterface)
    {
        $this->urlGenerator= $urlGeneratorInterface;
    }
    /**
     * @Route("/admin/order/order-adress/{id}/manage-adress", name="order_adress")
     */
    public function adress($id, AdressRepository $adressRepository): Response
    {
        return $this->renderForm('admin/order/adresses.html.twig',[
            'adresses' => $adressRepository->findByOrder($id),
        ]);
    }

    /**
     * @Route("/admin/order/client", name="order_client_index", methods={"GET"})
     */
    public function Clientindex(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin/order/client/index.html.twig', [
            'nbrOrders'=>count($orderRepository->findAll()),
            'orders'=>$orderRepository->findClient($user->getId()),
            'ordersCompleted'=>$orderRepository->findState('completed'),
            'ordersInProgress'=>$orderRepository->findState('in progress'),
            'ordersWaiting'=>$orderRepository->findState('waiting'),
            'ordersCanceled'=>$orderRepository->findState('canceled'),
        ]);
    }
    /**
     * @Route("/admin/order/", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'nbrOrders'=>count($orderRepository->findAll()),
            'orders'=>$orderRepository->findAll(),
            'ordersCompleted'=>$orderRepository->findState('completed'),
            'ordersInProgress'=>$orderRepository->findState('in progress'),
            'ordersWaiting'=>$orderRepository->findState('waiting'),
            'ordersCanceled'=>$orderRepository->findState('canceled'),
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/admin/order/new-order", name="order_user", methods={"GET","POST"})
     */
    public function newOrder(PaymentMethodRepository $paymentMethodRepository, ArticleRepository $articleRepository, Request $request, OrderService $orderService, SessionInterface $session): Response
    {
        $order = new Order();
        $order->setState('in progress');
        $order->setPaymentDue(new \DateTime('+ 6 day') );
        $user  = $this->getUser();
        $adresses = $user->getAdresses();
        $order->setUser($user);
        $panier = $session->get('panier');
        $total = 0;
        foreach ($panier as $key => $value) {
           $article = $articleRepository->find($key);
           $orderItem = new OrderItem();
           $orderItem->setProduitName($article->getTitle());
           $orderItem->setQuantity($value);
           $orderItem->setUnitPrice($article->getPrice());
           $orderItem->setUnitsTotal($orderItem->getUnitPrice() * $orderItem->getQuantity());
           $orderItem->setTotal($orderItem->getUnitsTotal() + $orderItem->getAdjustmentsTotal() );
           $total += $orderItem->getTotal();
           $orderItem->setArticle($article);
           $order->addOrderItem($orderItem);
        }
        $order->setItemsTotal($total);
        $order->setAdjustmentsTotal($order->getDeliverySpace()->getshippingAmount->getAmount());
        $order->setTotal($order->getItemsTotal() + $order->getAdjustmentsTotal() );
        $payment = new Payment();
        $payment->setAmount($order->getTotal());
        $payment->setState('in progress');
        $method = $paymentMethodRepository->find(3);
        $payment->setPaymentMethod($method);
        // $payment->setOrderPayment($order);
        // dump($total);
        // $order = $orderService->calculPersist($order);
        $order->setPayment($payment);
        
        // dd($order);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        $order->setNumber($order->getId());
        $entityManager->flush();
        $this->addFlash('success','Order created');
        $session->set('panier',[]);
        return $this->redirectToRoute('client_index',[],Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/admin/order/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request, OrderService $orderService, StreetRepository $streetRepository): Response
    {
        $order = new Order();
        $order->setNumber(1);
        $order->setShippingState('shipping');
        
        $form = $this->createForm(OrderNewType::class, $order);
        $form->handleRequest($request);
    

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $order = $orderService->calculPersist($order);

            $street = $form->get('street')->getData();
            if($street){

                //lieu de livraison
                $deliverySpace = new DeliverySpace();
                //rue de la livraison
                $street = $streetRepository->find($street->getId());
                $deliverySpace->setStreet($street);
                //client 
                $deliverySpace->setClient($form->get('user')->getData()->getClient());
            }
            $order->setDeliverySpace($deliverySpace);
            $entityManager->persist($order);
            $entityManager->flush();
            $order->setNumber($orderService->voiceNumber($order->getId()));
            $entityManager->flush($order);
            $this->addFlash('success','Commande enregistré');
            return $this->redirectToRoute('order_edit', ['id'=>$order->getId(),'tab'=>'articles'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/order/new.html.twig', [
            'order' => $order,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/admin/order/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/admin/order/print/{id}", name="order_print", methods={"GET"})
     * @Route("/customer/order/print/{id}", name="order_print_client", methods={"GET"})
     */
    public function invoice(Order $order): Response
    {
        return $this->render('admin/order/print.html.twig', [
            'order' => $order,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/admin/order/client/{id}/edit", name="order_edit_client", methods={"GET","POST"})
     * @Route("/admin/order/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit( Request $request, Order $order, OrderItemRepository $orderItemRepository,  OrderService $orderService, PaymentService $paymentService): Response
    {
        // debut payment
        $payment = $order->getPayment();
        $formPayment = $this->createForm(PaymentType::class, $payment);
        $formPayment->handleRequest($request);
        //en payment
       //Debut new orderItem 
        $orderItem = new OrderItem();
        $formItem = $this->createForm(OrderItemType::class, $orderItem);
        $formItem->handleRequest($request);
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
                $entityManager->flush();
                $orderService->calculOrder($order);
                $this->addFlash('success','Un article a été ajouté');
                return $this->redirectToRoute('order_edit', ['id'=>$order->getId()], Response::HTTP_SEE_OTHER);       
            }
            $this->addFlash('warning','Article existe dans la commande');
            
        }
        //end new orderItem
        
        // order 
        $form = $this->createForm(OrderType::class, $order,[
            'user'=>$order->getUser()
        ]);
        $form->handleRequest($request);
        $orderService->calculOrder($order);
        
        if ($form->isSubmitted() && $form->isValid()) {         
            if ($order->getIsImmuable()) //Si la commande est modifiable
            {
                if($order->getState() == 'completed')
                {
                    $payment->setState('completed');
                    $order->setPayment($payment);
                    $order->setCheckoutCompletedAt(new \DateTime());
                    foreach ($order->getOrderItem()->getValues() as $key => $value) {
                        $articleBuy = new ArticleBuy();
                        $articleBuy->setClient($order->getUser()->getClient());
                        $articleBuy->setArticle($value->getArticle());
                        $articleBuy->setPrice($value->getUnitPrice());
                        $articleBuy->setQuantity($value->getQuantity());
                        $this->getDoctrine()->getManager()->persist($articleBuy);
                    }
                }
                $order->setIsImmuable(false);
            }
            $orderService->calculOrder($order);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Order modified');
            return $this->redirectToRoute('order_edit', ['id'=>$order->getId()], Response::HTTP_SEE_OTHER);       
        }
        $payment = $order->getPayment();
        $payment->setAmount($order->getTotal());

        $paymentService->calculPayment($payment);
        $order->setPayment($payment);
        
        $breadcrumb=
        [
            [
                'path'=>$this->urlGenerator->generate('order_index'),
                'name'=>'Manage orders'
            ]
        ];
        return $this->renderForm('admin/order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
            'formItem' => $formItem,
            'formFacturation'=>$formPayment,
            'breadcrumb'=>$breadcrumb,
            'orderStatus'=>Order::status
        ]);
    }

    /**
     * @Route("/editor-order-get-home", name="editor_order_edit_get_home", methods={"GET","POST"})
     * @Route("/editor/order/{id}/edit/get", name="editor_order_edit_get", methods={"GET","POST"})
     */
    public function editOrdeGet(Order $order = null, Request $request, OrderRepository $orderRepository){

        if($request->request->get('load') && $request->request->get('load') == 'order-home'){
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_order_home.html.twig',[
                    'lastOrder'=>$orderRepository->findAllLast()
                ])->getContent()
            ]);
        }
        if($request->request->get('load') && $request->request->get('load') == 'order-edit'){
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_order_edit_get.html.twig',['order'=>$order])->getContent()
            ]);
        }
        if ($request->request->get('modal') && $request->request->get('modal') == 'state') {
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_state.html.twig',[
                    'order'=>$order,'orderStatus'=>Order::status
                    ]
                    )->getContent()
            ]);
        }
        if ($request->request->get('modal') && $request->request->get('modal') == 'limite') {
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_date_limite.html.twig',['order'=>$order])->getContent()
            ]);
        }

        if ($request->request->get('modal') && $request->request->get('modal') == 'create') {
            return new JsonResponse([
                'reponse'=>true,
                'content'=>$this->render('admin/order/_date_emission.html.twig',['order'=>$order])->getContent()
            ]);
        }
        
        return new JsonResponse([
            'reponse'=>false,
        ]);
    }
    
    /**
     * @Route("/editor/order/{id}/edit", name="editor_order_edit", methods={"GET","POST"})
     *
     */
    public function editOrder(Order $order,MailerInterface $mailer, DeliverySpaceRepository $deliverySpaceRepository, StreetRepository $streetRepository, Request $request, OrderService $orderService){

        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->request->get('date_emission')){
            $date_emission = $request->request->get('date_emission');
            $order->setCreatedAt(new \DateTime($date_emission));
            $entityManager->flush();
            return new JsonResponse(true);
        }

        if($request->request->get('date_limite')){
            $date_limite = $request->request->get('date_limite');
            $order->setPaymentDue(new \DateTime($date_limite));
            $entityManager->flush();
            return new JsonResponse(true);
        }
        $orderService->calculOrder($order);

        if($this->isCsrfTokenValid('edit'.$order->getId(),$request->request->get('_token')) && $request->request->get('state')){
            $state = $request->request->get('state');
            if ($order->getIsImmuable()) //Si la commande est modifiable
            {
                if($state == 'completed')
                    {
                    $payment = $order->getPayment();
                    $payment->setState('completed');
                    $order->setState($state);
                    $order->setPayment($payment);
                    $order->setCheckoutCompletedAt(new \DateTime());
                    foreach ($order->getOrderItem()->getValues() as $key => $value) {
                        $articleBuy = new ArticleBuy();
                        $articleBuy->setClient($order->getUser()->getClient());
                        $articleBuy->setArticle($value->getArticle());
                        $articleBuy->setPrice($value->getUnitPrice());
                        $articleBuy->setQuantity($value->getQuantity());
                        $this->getDoctrine()->getManager()->persist($articleBuy);
                    }
                    $order->setIsImmuable(false);
                    $mailer->send($orderService->orderSendToEmail($order));
                }
            }
            $order->setState($state);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        if($this->isCsrfTokenValid('edit'.$order->getId(),$request->request->get('_token')) && $request->request->get('note')){
            $note = $request->request->get('note');
            $order->setNote($note);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/admin/order/{id}", name="order_delete", methods={"POST"})
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