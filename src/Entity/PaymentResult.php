<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PaymentResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PaymentResultRepository::class)
 */
class PaymentResult
{
    /**
     * @Groups({ "order_read"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailAddress;

    /**
     * @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updateTime;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="paymentResult")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function getUpdateTime(): ?string
    {
        return $this->updateTime;
    }

    public function setUpdateTime(?string $updateTime): self
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPaymentResult($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPaymentResult() === $this) {
                $order->setPaymentResult(null);
            }
        }

        return $this;
    }
}
