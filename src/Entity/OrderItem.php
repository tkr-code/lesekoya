<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     * @ORM\Column(type="integer", options={"default":"1"})
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $unit_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $units_total;

    /**
     * @ORM\Column(type="integer", nullable="true", options={"default":"1"} )
     */
    private $adjustments_total;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $produit_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $variant_name;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="order_item")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class)
     */
    private $article;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reduction;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unit_price;
    }

    public function setUnitPrice(int $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getUnitsTotal(): ?int
    {
        return $this->units_total;
    }

    public function setUnitsTotal(int $units_total): self
    {
        $this->units_total = $units_total;

        return $this;
    }

    public function getAdjustmentsTotal(): ?int
    {
        return $this->adjustments_total;
    }

    public function setAdjustmentsTotal(int $adjustments_total): self
    {
        $this->adjustments_total = $adjustments_total;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getProduitName(): ?string
    {
        return $this->produit_name;
    }

    public function setProduitName(?string $produit_name): self
    {
        $this->produit_name = $produit_name;

        return $this;
    }

    public function getVariantName(): ?string
    {
        return $this->variant_name;
    }

    public function setVariantName(?string $variant_name): self
    {
        $this->variant_name = $variant_name;

        return $this;
    }

    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(?int $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }
}