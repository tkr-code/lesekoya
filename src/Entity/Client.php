<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=DeliverySpace::class, mappedBy="client")
     */
    private $deliverySpaces;

    /**
     * @ORM\OneToMany(targetEntity=ArticleBuy::class, mappedBy="client", orphanRemoval=true)
     */
    private $articleBuys;

    public function __construct()
    {
        $this->deliverySpaces = new ArrayCollection();
        $this->articleBuys = new ArrayCollection();
    }

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
            $deliverySpace->setClient($this);
        }

        return $this;
    }

    public function removeDeliverySpace(DeliverySpace $deliverySpace): self
    {
        if ($this->deliverySpaces->removeElement($deliverySpace)) {
            // set the owning side to null (unless already changed)
            if ($deliverySpace->getClient() === $this) {
                $deliverySpace->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleBuy[]
     */
    public function getArticleBuys(): Collection
    {
        return $this->articleBuys;
    }

    public function addArticleBuy(ArticleBuy $articleBuy): self
    {
        if (!$this->articleBuys->contains($articleBuy)) {
            $this->articleBuys[] = $articleBuy;
            $articleBuy->setClient($this);
        }

        return $this;
    }

    public function removeArticleBuy(ArticleBuy $articleBuy): self
    {
        if ($this->articleBuys->removeElement($articleBuy)) {
            // set the owning side to null (unless already changed)
            if ($articleBuy->getClient() === $this) {
                $articleBuy->setClient(null);
            }
        }

        return $this;
    }
}
