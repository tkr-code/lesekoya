<?php

namespace App\Entity;

use App\Repository\ShippingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippingRepository::class)
 */
class Shipping
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="shipping", cascade={"persist", "remove"})
     */
    private $order_shipping;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getOrderShipping(): ?Order
    {
        return $this->order_shipping;
    }

    public function setOrderShipping(?Order $order_shipping): self
    {
        // unset the owning side of the relation if necessary
        if ($order_shipping === null && $this->order_shipping !== null) {
            $this->order_shipping->setShipping(null);
        }

        // set the owning side of the relation if necessary
        if ($order_shipping !== null && $order_shipping->getShipping() !== $this) {
            $order_shipping->setShipping($this);
        }

        $this->order_shipping = $order_shipping;

        return $this;
    }
}
