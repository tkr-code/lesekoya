<?php
namespace App\Service\Order;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService{
    private $em;
    private $repository;
    public function __construct(EntityManagerInterface $manager, OrderItemRepository $repository)
    {
        $this->em = $manager;
        $this->repository = $repository;
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
       $order->setTotal($this->subTotal($order) + $order->getShipping());

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