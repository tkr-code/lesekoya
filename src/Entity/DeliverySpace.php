<?php

namespace App\Entity;

use App\Repository\DeliverySpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliverySpaceRepository::class)
 */
class DeliverySpace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Street::class, inversedBy="deliverySpaces", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $street;


    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="delivery_space", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="deliverySpaces")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="delivery_space")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?Street
    {
        return $this->street;
    }

    public function setStreet(?Street $street): self
    {
        $this->street = $street;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setDeliverySpace(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getDeliverySpace() !== $this) {
            $user->setDeliverySpace($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setDeliverySpace($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getDeliverySpace() === $this) {
                $order->setDeliverySpace(null);
            }
        }

        return $this;
    }
}
