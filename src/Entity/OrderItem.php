<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  @ApiResource(
 *     normalizationContext={"groups"={"orderItem_read"}},
 *     denormalizationContext={"groups"={"orderItem_write"}},
 *     paginationItemsPerPage=20,
 *     collectionOperations={
 *          "get"={},
 *          "post"={}
 *     },
 *     itemOperations={
 *          "get"={},
 *          "delete"={},
 *          "put"={},
 *          
 *     },
 * )
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @Groups({ "order_read", "order_write", "orderItem_read", "product_read", "orderItem_write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({ "order_read", "order_write", "orderItem_read", "product_read", "orderItem_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups({ "order_read", "order_write", "orderItem_read", "product_read", "orderItem_write"})
     * @ORM\Column(type="float")
     */
    private $qty;

    /**
     * @Groups({ "order_read", "order_write", "orderItem_read", "product_read", "orderItem_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Groups({ "order_read", "order_write", "orderItem_read", "product_read", "orderItem_write"})
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Groups({  "orderItem_read", "orderItem_write"})
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productOrderItems")
     */
    private $product;

    /**
     * @Groups({  "orderItem_read", "orderItem_write"})
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderItems")
     */
    private $theOrder;

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

    public function getQty(): ?float
    {
        return $this->qty;
    }

    public function setQty(float $qty): self
    {
        $this->qty = $qty;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getTheOrder(): ?Order
    {
        return $this->theOrder;
    }

    public function setTheOrder(?Order $theOrder): self
    {
        $this->theOrder = $theOrder;

        return $this;
    }
}
