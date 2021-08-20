<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default"="0"} )
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="payment", cascade={"persist", "remove"})
     */
    private $order_payment;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentMethod::class, inversedBy="payment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paymentMethod;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount = 0): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state ='in progress' ): self
    {
        $this->state = $state;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

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

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getOrderPayment(): ?Order
    {
        return $this->order_payment;
    }

    public function setOrderPayment(?Order $order_payment): self
    {
        // unset the owning side of the relation if necessary
        if ($order_payment === null && $this->order_payment !== null) {
            $this->order_payment->setPayment(null);
        }

        // set the owning side of the relation if necessary
        if ($order_payment !== null && $order_payment->getPayment() !== $this) {
            $order_payment->setPayment($this);
        }

        $this->order_payment = $order_payment;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}