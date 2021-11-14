<?php

namespace App\Entity;

use App\Repository\ParentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParentCategoryRepository::class)
 */
class ParentCategory
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
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="parentCategory", cascade={"persist"})
     */
    private $categorys;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    public function __construct()
    {
        $this->categorys = new ArrayCollection();
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

    /**
     * @return Collection|Category[]
     */
    public function getCategorys(): Collection
    {
        return $this->categorys;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categorys->contains($category)) {
            $this->categorys[] = $category;
            $category->setParentCategory($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categorys->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getParentCategory() === $this) {
                $category->setParentCategory(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
