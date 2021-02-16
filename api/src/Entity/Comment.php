<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"comment_read"}},
 *     denormalizationContext={"groups"={"comment_write"}},
 *     subresourceOperations={
 *        "api_products_comments_get_subresource"={
 *          "normalization_context"={"groups"={"comment_subresource"}}
 *        }
 *     },
 *     paginationItemsPerPage=20,
 *     collectionOperations={
 *          "get"={},
 *          "post"={}
 *     },
 *     itemOperations={
 *          "get"={},
 *          "delete"={},
 *          "put"={},
 *     }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @Groups({"comment_read","product_read" ,"user_read" ,"comment_subresource"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"comment_read", "comment_write", "product_read" ,"user_read" ,"comment_subresource"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;

    /**
     * @Groups({"comment_read", "comment_write", "product_read" ,"user_read" ,"comment_subresource"})
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Une note est obligatoire")
     */
    private $content;

    /**
     * @Groups({"comment_read", "comment_write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @Groups({"comment_read", "comment_write"})
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

      // GEDMO

    /**
     * @var \DateTime $createdAt
     * @Groups({"comment_read" ,"product_read" ,"user_read" ,"comment_subresource"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     * @Groups({"comment_read" , "product_read" , "user_read" , "comment_subresource"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    // END GEDMO

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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
}
