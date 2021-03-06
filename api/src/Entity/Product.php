<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *  attributes={
 *      "pagination_enabled"=true,
 *      "pagination_items_per_page"=20,
 *      "order": {"price":"desc"}
 *  },
 *  normalizationContext={"groups"={"product_read"}},
 *  denormalizationContext={"disable_type_enforcement"=true},
 *  collectionOperations={
 *          "get"={},
 *          "post"={},
 *          
 *     },
 *     itemOperations={
 *          "get"={},
 *          "delete"={},
 *          "put"={},
 *     },
 *  subresourceOperations={
 *  "api_orders_products_get_subresource"={
 *          "normalization_context"={"groups"={"product_order_subresource"}}
 *        },
 *  "api_categories_products_get_subresource"={
 *          "normalization_context"={"groups"={"product_subresource"}}
 *  }
 * },
 * )
 * @ApiFilter(OrderFilter::class, properties={"price","reference"})
 * @ApiFilter(SearchFilter::class, properties={"name":"partial","category.name":"partial"})
 * @ApiFilter(SearchFilter::class, properties={"name":"partial","name":"partial"})
 * @ApiFilter(SearchFilter::class, properties={"user_id.id"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom doit faire entre 3 et 255 caractères", max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères")
     */
    private $name;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le prix est obligatoire")
     * @Assert\Type(type="float", message="List price must be a numeric value")
     */
    private $price;

    /**
     * @Groups({"product_read", "orderItem_read"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @Groups({"product_read"})
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Groups({"product_read", "product_subresource", "product_order_subresource"})
     * @ApiSubresource
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product")
     */
    private $comments;

    /**
     * @Groups({"product_read"})
     * @ORM\OneToMany(targetEntity=Bookmark::class, mappedBy="product")
     * @ORM\JoinColumn(nullable=true)
     */
    private $bookmarks;

     // GEDMO

    /**
     * @var \DateTime $createdAt
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write", "bookmark_read", "comment_read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     * @Groups({"product_read" ,"category_read" ,"user_read", "bookmark_read", "comment_read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="float")
     */
    private $countInStock;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @Groups({"product_read" ,"category_read" ,"user_read", "order_read", "order_write","comment_read", "bookmark_read", "product_subresource", "product_order_subresource", "orderItem_read", "orderItem_write"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $numReviews;

    /**
     * @Groups({"product_read"})
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="product")
     */
    private $productOrderItems;

  


    // END GEDMO

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
        $this->productOrderItems = new ArrayCollection();
    }

    /**
     * Permet d'obtenir la moyenne globale des notes pour cet produit
     * @return float
     */
    public function getAvgRatings() {
        // Calculer la somme des notations
        $sum = array_reduce($this->comments->toArray(), function($total, $comment) {
            return $total + $comment->getRating();
        }, 0);

        // Faire la division pour avoir la moyenne
        if(count($this->comments) > 0) return $sum / count($this->comments);

        return 0; 
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bookmark[]
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): self
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks[] = $bookmark;
            $bookmark->setProduct($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getProduct() === $this) {
                $bookmark->setProduct(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    

    public function getCountInStock(): ?float
    {
        return $this->countInStock;
    }

    public function setCountInStock(float $countInStock): self
    {
        $this->countInStock = $countInStock;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getRating(): ?float
    {
        //return $this->rating;
        // Calculer la somme des notations
        $sum = array_reduce($this->comments->toArray(), function($total, $comment) {
            return $total + $comment->getRating();
        }, 0);

        // Faire la division pour avoir la moyenne
        if(count($this->comments) > 0) return $sum / count($this->comments);

        return 0; 
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getNumReviews(): ?float
    {
        //return $this->numReviews;
        return count($this->comments);
    }

    public function setNumReviews(?float $numReviews): self
    {
        $this->numReviews = $numReviews;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getProductOrderItems(): Collection
    {
        return $this->productOrderItems;
    }

    public function addProductOrderItem(OrderItem $productOrderItem): self
    {
        if (!$this->productOrderItems->contains($productOrderItem)) {
            $this->productOrderItems[] = $productOrderItem;
            $productOrderItem->setProduct($this);
        }

        return $this;
    }

    public function removeProductOrderItem(OrderItem $productOrderItem): self
    {
        if ($this->productOrderItems->removeElement($productOrderItem)) {
            // set the owning side to null (unless already changed)
            if ($productOrderItem->getProduct() === $this) {
                $productOrderItem->setProduct(null);
            }
        }

        return $this;
    }

    
}
