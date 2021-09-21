<?php

namespace App\Entity;

use App\Repository\ShippingAmountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=ShippingAmountRepository::class)
 * @UniqueEntity(
 *  fields="amount",
 *  message="Cette categorie existe "
 * )
 */
class ShippingAmount
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
     * @ORM\OneToMany(targetEntity=Street::class, mappedBy="shippingAmount")
     */
    private $street;

    public function __construct()
    {
        $this->street = new ArrayCollection();
    }

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

    /**
     * @return Collection|Street[]
     */
    public function getStreet(): Collection
    {
        return $this->street;
    }

    public function addStreet(Street $street): self
    {
        if (!$this->street->contains($street)) {
            $this->street[] = $street;
            $street->setShippingAmount($this);
        }

        return $this;
    }

    public function removeStreet(Street $street): self
    {
        if ($this->street->removeElement($street)) {
            // set the owning side to null (unless already changed)
            if ($street->getShippingAmount() === $this) {
                $street->setShippingAmount(null);
            }
        }

        return $this;
    }
}
