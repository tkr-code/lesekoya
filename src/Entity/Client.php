<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @UniqueEntity(
 *  fields="user",
 *  message="Cette categorie existe "
 * )
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="client", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=DeliverySpace::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $deliverySpace;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDeliverySpace(): ?DeliverySpace
    {
        return $this->deliverySpace;
    }

    public function setDeliverySpace(DeliverySpace $deliverySpace): self
    {
        // set the owning side of the relation if necessary
        if ($deliverySpace->getClient() !== $this) {
            $deliverySpace->setClient($this);
        }

        $this->deliverySpace = $deliverySpace;

        return $this;
    }
}
