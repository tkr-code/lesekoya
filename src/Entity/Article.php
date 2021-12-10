<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Table(name="article", indexes={@ORM\Index(columns={"title","description"}, flags={"fulltext"})})
 * @UniqueEntity(
 *  fields="title"
 * )
 */
class Article
{
    const etats =[
        'Top'=>'Top',
        'Tendance'=>'Tendance',
        'Populaire'=>'Populaire',
        'Meilleurs ventes'=>'Meilleurs ventes'
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(
     *     min = 3,
     *     max = 70
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime" ,options={"default"="CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * 
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="produit", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=ArticleOption::class, mappedBy="article", orphanRemoval=true)
     */
    private $options;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotNull
     */
    private $buyingPrice;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="favoris")
     */
    private $favori;

    /**
     * @ORM\OneToMany(targetEntity=ArticleBuy::class, mappedBy="article", orphanRemoval=true)
     */
    private $articleBuys;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty_reel;


    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->favori = new ArrayCollection();
        $this->articleBuys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSlug()
    {
        return (new Slugify())->slugify($this->title);
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title =ucfirst($title);

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }
    public function formatterBuying()
    {
        return number_format($this->buyingPrice,0,'', ' ');
    }
    public function formatterPrice()
    {
        return number_format($this->price,0,'', ' ');
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = ucfirst($description);

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(ArticleOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setArticle($this);
        }

        return $this;
    }

    public function removeOption(ArticleOption $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getArticle() === $this) {
                $option->setArticle(null);
            }
        }

        return $this;
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

    public function getBuyingPrice(): ?float
    {
        return $this->buyingPrice;
    }

    public function setBuyingPrice(float $buyingPrice): self
    {
        $this->buyingPrice = $buyingPrice;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFavori(): Collection
    {
        return $this->favori;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favori->contains($favori)) {
            $this->favori[] = $favori;
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favori->removeElement($favori);

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
            $articleBuy->setArticle($this);
        }

        return $this;
    }

    public function removeArticleBuy(ArticleBuy $articleBuy): self
    {
        if ($this->articleBuys->removeElement($articleBuy)) {
            // set the owning side to null (unless already changed)
            if ($articleBuy->getArticle() === $this) {
                $articleBuy->setArticle(null);
            }
        }

        return $this;
    }

    public function getQtyReel(): ?int
    {
        return $this->qty_reel;
    }

    public function setQtyReel(int $qty_reel): self
    {
        $this->qty_reel = $qty_reel;

        return $this;
    }

}