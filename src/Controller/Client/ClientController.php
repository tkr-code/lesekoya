<?php

namespace App\Controller\Client;

use App\Entity\Order;
use App\Entity\Client;
use App\Entity\Payment;
use App\Form\ClientType;
use App\Entity\OrderItem;
use App\Entity\ArticleSearch;
use App\Entity\DeliverySpace;
use App\Entity\Shipping;
use App\Form\ArticleSearchType;
use App\Form\Payment1Type;
use App\Repository\OrderRepository;
use App\Service\Order\OrderService;
use App\Repository\ClientRepository;
use App\Repository\ArticleRepository;
use App\Repository\PaymentMethodRepository;
use App\Repository\StreetRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/customer")
 */
class ClientController extends AbstractController
{
    /**
     * confirmation
     * @Route("/confirmation/{id}", name="client_confirmation")
     * @return Response
     */
    public function confirmation(Order $order):Response
    {
        return $this->renderForm('client/confirmation.html.twig',[
            'order'=>$order
        ]);
    }
    /**
     * @Route("/order-adress", name="order_client_shipping")
     */
    public function orderClientShipping(CartService $cartService): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        $payment = new Payment();
        $formPayment = $this->createForm(Payment1Type::class,$payment);
        return $this->renderForm('client/adress.html.twig',[
            'form'=>$form,
            'items'=>$cartService->getFullCart(),
            'total'=>$cartService->getTotal(),
            'formPayment'=>$formPayment
        ]);
    }
        /**
     * @Route("/order/new-order", name="order_client_new", methods={"POST"})
     */
    public function newOrder(OrderRepository $orderRepository, StreetRepository $streetRepository, PaymentMethodRepository $paymentMethodRepository, ArticleRepository $articleRepository, Request $request, OrderService $orderService, SessionInterface $session): Response
    {

        // nouvelle commande
        // dd($request->request);
        $order = new Order();
        //methode de paiment
        $id_methodPayment = $session->get('methodPayment');
        //rue de la livraison
        $street = $session->get('shipping');
        $street = $streetRepository->find($street->getId());
        $order->setState('in progress');
        // $order->setShipping(500);
        $order->setNumber($orderService->voiceNumber());
        $order->setPaymentDue(new \DateTime('+ 6 day') );
        $user  = $this->getUser();
        $adresses = $user->getAdresses();
        // $order->setShippingAdress($adresses[0]);
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
        // $order->setAdjustmentsTotal($order->getShipping());
        $order->setTotal($order->getItemsTotal());
        
        $payment = new Payment();
        $payment->setAmount($order->getTotal());
        $payment->setState('in progress');
        $method = $paymentMethodRepository->find($id_methodPayment);
        $payment->setPaymentMethod($method);
        // livraison
        $shipping = new Shipping();
        //montant de la livraison
        $shippingAmount = $street->getShippingAmount()->getAmount();
        $shipping->setAmount($shippingAmount);
        $order->setAdjustmentsTotal($shippingAmount);
        $order->setTotal($order->getTotal()+ $order->getAdjustmentsTotal());
        //statut de la livraison
        $shipping->setState('In progress');

        //lieu de livraison
        $deliverySpace = new DeliverySpace();
        //rue de la livraison
        $deliverySpace->setStreet($street);
        //client 
        $deliverySpace->setClient($user->getClient());
        
        $order->setPayment($payment);
        $order->setShipping($shipping);
        $order->setDeliverySpace($deliverySpace);
        
        // dd($order);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        $this->addFlash('success','Order created');
        $session->set('panier',[]);
        return $this->redirectToRoute('client_confirmation',['id'=>$order->getId()]);
    }
    /**
     * @Route("/order/{id}", name="client_order_show", methods={"GET"})
     */
    public function ordershow(Order $order): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        return $this->renderForm('client/order/show.html.twig', [
            'order' => $order,
            'form'=>$form
        ]);
    }
    /**
     * buy
     * @Route("/buy", name="client_buy")
     * @return void
     */
    public function buy():Response
    {
        return $this->render('client/buy/index.html.twig');
    }
    /**
     * @Route("/order", name="client_order", methods={"GET"})
     */
    public function clientOrder(OrderRepository $orderRepository): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        $user = $this->getUser();
        return $this->renderForm('client/order/index.html.twig', [
            'form'=>$form,
            'orders'=>$orderRepository->findClient($user->getId()),
            'ordersWaiting'=>$orderRepository->findClientState($user->getId(),'waiting'),
            'ordersInProgress'=>$orderRepository->findClientState($user->getId()),
            'ordersCanceled'=>$orderRepository->findClientState($user->getId(),'canceled'),
            'ordersCompleted'=>$orderRepository->findClientState($user->getId(),'completed'),
        ]);
    }
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        $search = new ArticleSearch();
        $form = $this->createForm(ArticleSearchType::class,$search);
        return $this->renderForm('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
            'form'=>$form
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
    }


}