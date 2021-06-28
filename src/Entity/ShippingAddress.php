<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ShippingAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ShippingAddressRepository::class)
 */
class ShippingAddress
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
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     *  @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     *  @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     *  @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $postalCode;

    /**
     *  @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="shippingAddress")
     */
    private $theOrder;

    /**
     * @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     */
    private $lat;

    /**
     * @Groups({ "order_read", "order_write"})
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     */
    private $lng;

    

    public function __construct()
    {
        
    }

    

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    

    


}
