<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Shipping;
use App\Entity\OrderItem;
use App\Entity\DeliverySpace;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\PaymentMethodRepository;
use App\Repository\StreetRepository;
use App\Service\Order\OrderService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    private $orderService;
    private $streetRepository;
    private $paymentMethodRepository;
    public function __construct(StreetRepository $streetRepository, OrderService $orderService, PaymentMethodRepository $paymentMethodRepository )
    {
       $this->streetRepository = $streetRepository;
       $this->orderService = $orderService;
       $this->paymentMethodRepository = $paymentMethodRepository;
    }
    public function load(ObjectManager $manager)
    {
        // nouvelle commande
        $order = new Order();
        $order->setNumber($this->orderService->voiceNumber(1));
        $order->setState(Order::EN_ATTENTE);
        $order->setPaymentDue(new \DateTime('+ 6 day'));
        $order->setUser($this->getReference('client_client@store.com'));
        
        // //initialise l'article
        $article = $this->getReference('_article_Hp_elitebook_Folio_G1');
        // //initialise la ligne de la commande
        $orderItem = new OrderItem();
        $orderItem->setReduction($article->getReduction());
        $orderItem->setProduitName($article->getTitle());
        $orderItem->setQuantity(2);
        $orderItem->setUnitPrice($article->getNewPrice());
        $orderItem->setUnitsTotal($orderItem->getUnitPrice() * $orderItem->getQuantity());
        $orderItem->setTotal($orderItem->getUnitsTotal() + $orderItem->getAdjustmentsTotal());
        
        $total = 0;
        $total += $orderItem->getTotal();
        
        $orderItem->setArticle($article);
        $order->addOrderItem($orderItem);
        $order->setItemsTotal($total);
        $order->setAdjustmentsTotal($order->getShipping());
        $order->setTotal($order->getItemsTotal());
        $order->setShippingState(Order::EN_ATTENTE);

        $payment = new Payment();
        $payment->setAmount($order->getTotal());
        $payment->setState('In progress');
        $method = $this->paymentMethodRepository->findOneBy(['name' => 'Payement à la livraison']);
        $method = $this->getReference('_method_Payement_à_la_livraison');
        $payment->setPaymentMethod($method);
        $order->setMethodPayment($method->getName());
        // // livraison
        $shipping = new Shipping();
        // //montant de la livraison
        $street = $this->getReference('_street_Sacre_ceour_2');
        $shippingAmount = $street->getShippingAmount()->getAmount();
        $shipping->setAmount($shippingAmount);
        $order->setShipping($shippingAmount);
        $order->setAdjustmentsTotal($shippingAmount);
        $order->setTotal($order->getTotal() + $order->getAdjustmentsTotal());
        // //statut de la livraison
        $shipping->setState('In progress');

        // //lieu de livraison
        $deliverySpace = new DeliverySpace();
        // //rue de la livraison
        $street = $this->streetRepository->find($street->getId());
        $deliverySpace->setStreet($street);
        // //client 
        // $user = $this->getReference('client_test');
        // $deliverySpace->setClient($user->getClient());

        $order->setPayment($payment);
        $order->setDeliverySpace($deliverySpace);
        
        $manager->persist($order);
        $manager->flush();
        
    }

    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            StreetFixtures::class,
            DevFixtures::class,
            PaymentMethodFixtures::class
        ];
    }
}
