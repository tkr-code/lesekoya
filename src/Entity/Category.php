<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @UniqueEntity(
 *  fields="title",
 *  message="Cette categorie existe "
 * )
 */
class Category
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min = 3,
     *     max = 70
     * )
     * @Assert\NotBlank()
     */
    private $title;



    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    /**
     * @ORM\ManyToOne(targetEntity=ParentCategory::class, inversedBy="categorys")
     */
    private $parentCategory;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getSlug()
    {
        return str_replace(' ','-',$this->title);
    }

    public function setTitle(string $title): self
    {
        $this->title = ucfirst($title);

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
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

    /**
     * @return Collection|self[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getParentCategory(): ?ParentCategory
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?ParentCategory $parentCategory): self
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }
}