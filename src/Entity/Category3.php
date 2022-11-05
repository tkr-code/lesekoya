<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\Category3Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=Category3Repository::class)
 */
class Category3
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Category2::class, mappedBy="category3")
     */
    private $categorys2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    public function __construct()
    {
        $this->categorys2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug()
    {
        $Slugify = new Slugify();
        
        return $Slugify->slugify($this->title);
    }
    /**
     * @return Collection<int, Category2>
     */
    public function getCategorys2(): Collection
    {
        return $this->categorys2;
    }

    public function addCategorys2(Category2 $categorys2): self
    {
        if (!$this->categorys2->contains($categorys2)) {
            $this->categorys2[] = $categorys2;
            $categorys2->setCategory3($this);
        }

        return $this;
    }

    public function removeCategorys2(Category2 $categorys2): self
    {
        if ($this->categorys2->removeElement($categorys2)) {
            // set the owning side to null (unless already changed)
            if ($categorys2->getCategory3() === $this) {
                $categorys2->setCategory3(null);
            }
        }

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
