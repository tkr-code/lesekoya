<?php
namespace App\Service\Order;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Shipping;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService{
    private $em;
    private $repository;
    private $orderRepository;
    public function __construct(EntityManagerInterface $manager, OrderItemRepository $repository, OrderRepository $orderRepository)
    {
        $this->em = $manager;
        $this->repository = $repository;
        $this->orderRepository = $orderRepository;
    }
    public function voiceNumber()
    {
        $invoice= 1;
        $orders = $this->orderRepository->findLast();
        foreach($orders as $order)
        {
           $invoice += $order->getNumber();
        }
        return   sprintf("%06s", $invoice);
    }
    public function addQuantity(int $id, $qty)
    {
        $orderItem = $this->repository->find($id);
        $orderItem->setQuantity($qty);
        $this->em->flush();
        return $orderItem->getCommande()->getId();
        
    }
    public function update(int $id,OrderItem $orderItem)
    {
        $update = $this->repository->find($id);
        $orderItem->setArticle($update->getArticle());
        // $orderItem->setProduitName($update->getProduitName());
        // $this->priceItem($orderItem);
        // $this->em->flush();
        dump($update);
    }

    public function orderItemAdd(OrderItem $orderItem, Order $order)
    {
        
        $orderItem->setCommande($order);

        $this->priceItem($orderItem);
        

        $orderItem->setUnitsTotal($this->subTotatlItem($orderItem));
        
        $orderItem->setTotal($orderItem->getUnitsTotal());
        
    }

    public function priceItem($orderItem)
    {
        $article = $orderItem->getArticle();
        $orderItem->setProduitName($article->getTitle());
        $price = ($orderItem->getUnitPrice() == 0 )? $article->getPrice(): $orderItem->getUnitPrice();
        $orderItem->setUnitPrice($price);

    }

    public function subTotatlItem(OrderItem $orderItem)
    {
       return $orderItem->getUnitPrice() * $orderItem->getQuantity();
    }
    public function subTotal(Order $order)
    {
            $subTotalItem = 0;
        // on fait la somme de prix unitaire par la quantite
            foreach($order->getOrderItem() as $item)
            {
               $subTotalItem += $this->subTotatlItem($item);
            }
            return $subTotalItem;
    }
        
    /**
     * Calcul le total d'une commande 
     * total :
     *
     * @param  mixed $order
     * @return void
     */
    public function total(Order $order)
    {
       $order->setTotal($this->subTotal($order) + $order->getAdjustmentsTotal() );

        return $order;
    }
    public function calculPersist(Order $order){
        $payment = $order->getPayment();
        $payment->setAmount(0);
        // $order->setPaymentState('in progress');
        // $order->setShippingState('in progress');
        $order->setPaymentDue(new \DateTime('+ 5 day') );
        $order->setItemsTotal(0);
        $order->setState('in progress');
        $order->setAdjustmentsTotal(0);
        // $order->setShippingAdress($order->getUser()->getAdress());
        $order->setNumber($this->voiceNumber());
        // $order->setCheckoutState('in progress');
        $order->setTotal(0);
        return $order;
    }
    public function calculOrder(Order $order)
    {
        $order->setItemsTotal($this->subTotal($order));

        $this->total($order);
        
        $this->em->flush($order);

        // $payment = $order->getPayment();
        // $payment->setAmount($order->getTotal());
        // $this->em->flush($payment);
    }
}