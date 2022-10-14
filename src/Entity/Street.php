<?php

namespace App\Entity;

use App\Repository\StreetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=StreetRepository::class)
 * @UniqueEntity(
 *  fields="name",
 *  message="Cette valeur existe "
 * )
 */
class Street
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="streets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=ShippingAmount::class, inversedBy="street", cascade={"persist"})
     */
    private $shippingAmount;

    /**
     * @ORM\OneToMany(targetEntity=DeliverySpace::class, mappedBy="street")
     */
    private $deliverySpaces;


    public function __construct()
    {
        $this->deliverySpaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getShippingAmount(): ?ShippingAmount
    {
        return $this->shippingAmount;
    }

    public function setShippingAmount(?ShippingAmount $shippingAmount): self
    {
        $this->shippingAmount = $shippingAmount;

        return $this;
    }

    /**
     * @return Collection|DeliverySpace[]
     */
    public function getDeliverySpaces(): Collection
    {
        return $this->deliverySpaces;
    }

    public function addDeliverySpace(DeliverySpace $deliverySpace): self
    {
        if (!$this->deliverySpaces->contains($deliverySpace)) {
            $this->deliverySpaces[] = $deliverySpace;
            $deliverySpace->setStreet($this);
        }

        return $this;
    }

    public function removeDeliverySpace(DeliverySpace $deliverySpace): self
    {
        if ($this->deliverySpaces->removeElement($deliverySpace)) {
            // set the owning side to null (unless already changed)
            if ($deliverySpace->getStreet() === $this) {
                $deliverySpace->setStreet(null);
            }
        }

        return $this;
    }
}