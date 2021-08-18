<?php
namespace App\Service\Order;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;

class OrderService{
    private $em;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }
    public function orderItemAdd(OrderItem $orderItem, Order $order)
    {
        $article = $orderItem->getArticle();
        $orderItem->setCommande($order);
        $orderItem->setProduitName($article->getTitle());
        $price = ($orderItem->getUnitPrice() == 0 )? $article->getPrice(): $orderItem->getUnitPrice();
        $orderItem->setUnitPrice($price);

        

        $orderItem->setUnitsTotal($this->subTotatlItem($orderItem));
        
        $orderItem->setTotal($orderItem->getUnitsTotal());
        return $orderItem;
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
      return  $this->subTotal($order);
        //on insere le resulat dans la collone total_uninite
        
        //on ajuste e total sil existe des code promo
        //on insere la somme de total_unite , adjustements_total dans total_item
        // 
        
        // tolal commande
        // On fait la somme des lignes commandée


    }

    public function calculOrder(Order $order):Order
    {
        $order->setItemsTotal($this->subTotal($order));

        $subTotal = $this->subTotal($order);
        $total = $subTotal + $order->getAdjustmentsTotal();
        $order->setTotal($total);
        
        return $order;
    }
}