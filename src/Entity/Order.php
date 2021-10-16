<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $checkout_completed_at;


    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;


    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="commande", orphanRemoval=true, cascade={"persist"})
     */
    private $order_item;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paymentDue;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, inversedBy="order_payment", cascade={"persist", "remove"})
     */
    private $payment;

    /**
     * @ORM\Column(type="integer")
     */
    private $items_total;

    /**
     * @ORM\Column(type="integer")
     */
    private $adjustments_total;

    /**
     * @ORM\ManyToOne(targetEntity=DeliverySpace::class, inversedBy="orders", cascade={"persist"})
     */
    private $delivery_space;

    /**
     * @ORM\Column(type="boolean" ,options={"default"="1"})
     */
    private $is_immuable;


    public function __construct()
    {
        $this->order_item = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->is_immuable = true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;
        // sprintf("%06s", 1);

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCheckoutCompletedAt(): ?\DateTimeInterface
    {
        return $this->checkout_completed_at;
    }

    public function setCheckoutCompletedAt(?\DateTimeInterface $checkout_completed_at): self
    {
        $this->checkout_completed_at = $checkout_completed_at;

        return $this;
    }


    public function getTotal(): ?int
    {
        return $this->total;
    }
    public function formatterTotal()
    {
        return number_format($this->total,0,'',' ');
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItem(): Collection
    {
        return $this->order_item;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->order_item->contains($orderItem)) {
            $this->order_item[] = $orderItem;
            $orderItem->setCommande($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->order_item->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getCommande() === $this) {
                $orderItem->setCommande(null);
            }
        }

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPaymentDue(): ?\DateTimeInterface
    {
        return $this->paymentDue;
    }

    public function setPaymentDue(\DateTimeInterface $paymentDue): self
    {
        $this->paymentDue = $paymentDue;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getItemsTotal(): ?int
    {
        return $this->items_total;
    }

    public function setItemsTotal(int $items_total): self
    {
        $this->items_total = $items_total;

        return $this;
    }

    public function getAdjustmentsTotal(): ?int
    {
        return $this->adjustments_total;
    }

    public function setAdjustmentsTotal($adjustments_total): self
    {
        $this->adjustments_total =(int) $adjustments_total;

        return $this;
    }

    public function getDeliverySpace(): ?DeliverySpace
    {
        return $this->delivery_space;
    }

    public function setDeliverySpace(?DeliverySpace $delivery_space): self
    {
        $this->delivery_space = $delivery_space;

        return $this;
    }

    public function getIsImmuable(): ?bool
    {
        return $this->is_immuable;
    }

    public function setIsImmuable(bool $is_immuable): self
    {
        $this->is_immuable = $is_immuable;

        return $this;
    }
}