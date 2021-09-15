<?php

namespace App\Entity;

use App\Repository\DeliverySpaceRepository;
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
     * @ORM\ManyToOne(targetEntity=Street::class, inversedBy="deliverySpaces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $street;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, inversedBy="deliverySpace", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="delivery_space", cascade={"persist", "remove"})
     */
    private $commande;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        // unset the owning side of the relation if necessary
        if ($commande === null && $this->commande !== null) {
            $this->commande->setDeliverySpace(null);
        }

        // set the owning side of the relation if necessary
        if ($commande !== null && $commande->getDeliverySpace() !== $this) {
            $commande->setDeliverySpace($this);
        }

        $this->commande = $commande;

        return $this;
    }
}
