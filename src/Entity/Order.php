<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"order_read"}},
 *     denormalizationContext={"groups"={"order_write"}},
 *     paginationItemsPerPage=20,
 *     collectionOperations={
 *          "get"={},
 *          "post"={}
 *     },
 *     itemOperations={
 *          "get"={},
 *          "delete"={},
 *          "put"={},
 *          "post"={},
 *          
 *     }
 * )
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @Groups({"order_read","user_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"order_read", "order_write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false, nullable=true)
     */
    private $customer;

    /**
     * @Groups({"order_read", "order_write"})
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="orders")
     */
    private $orderItems;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

     // GEDMO

    /**
     * @var \DateTime $createdAt
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="string", length=255, nullable=true,)
     */
    private $paymentMethod;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="float", nullable=true,)
     */
    private $itemsPrice;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="float", nullable=true,)
     */
    private $shippingPrice;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="float", nullable=true,)
     */
    private $taxPrice;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="float", nullable=true,)
     */
    private $totalPrice;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $isPaid;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidAt;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="boolean", nullable=true, options={"default":false})
     */
    private $isDelivered;

    /**
     * @Groups({"order_read", "order_write", "user_read"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveredAt;

    /**
     * @Groups({"order_read", "order_write"})
     * @ORM\ManyToOne(targetEntity=ShippingAddress::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shippingAddress;

    /**
     * @Groups({"order_read", "order_write"})
     * @ORM\ManyToOne(targetEntity=PaymentResult::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentResult;

    

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    // END GEDMO

    

 

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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

    

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getItemsPrice(): ?float
    {
        return $this->itemsPrice;
    }

    public function setItemsPrice(float $itemsPrice): self
    {
        $this->itemsPrice = $itemsPrice;

        return $this;
    }

    public function getShippingPrice(): ?float
    {
        return $this->shippingPrice;
    }

    public function setShippingPrice(float $shippingPrice): self
    {
        $this->shippingPrice = $shippingPrice;

        return $this;
    }

    public function getTaxPrice(): ?float
    {
        return $this->taxPrice;
    }

    public function setTaxPrice(float $taxPrice): self
    {
        $this->taxPrice = $taxPrice;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(?bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paidAt;
    }

    public function setPaidAt(?\DateTimeInterface $paidAt): self
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    public function getIsDelivered(): ?bool
    {
        return $this->isDelivered;
    }

    public function setIsDelivered(bool $isDelivered): self
    {
        $this->isDelivered = $isDelivered;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeInterface
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?\DateTimeInterface $deliveredAt): self
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    public function getShippingAddress(): ?ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(?ShippingAddress $shippingAddress): self
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(Product $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
        }

        return $this;
    }

    public function removeOrderItem(Product $orderItem): self
    {
        $this->orderItems->removeElement($orderItem);

        return $this;
    }

    public function getPaymentResult(): ?PaymentResult
    {
        return $this->paymentResult;
    }

    public function setPaymentResult(?PaymentResult $paymentResult): self
    {
        $this->paymentResult = $paymentResult;

        return $this;
    }
}
