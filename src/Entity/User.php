<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
* @ApiResource(
 *     normalizationContext={"groups"={"user_read"}},
 *     denormalizationContext={"groups"={"user_write"}},
 *     paginationItemsPerPage=20,
 *     collectionOperations={
 *          "get"={},
 *          "post"={}
 *     },
 *     itemOperations={
 *          "get"={},
 *          "put"={},
 *          "delete"={},
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email", message="Un utilisateur ayant cette adresse email existe déjà")
 */
class User implements UserInterface
{
    /**
     * @Groups({ "product_read" , "comment_read", "bookmark_read", "message_read", "order_read", "user_read", "product_subresource", "comment_subresource"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({ "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "user_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'email doit être renseigné !")
     * @Assert\Email(message="L'adresse email doit avoir un format valide !")
     */
    private $email;

    /**
     * @Groups({
     *     "user_write", "user_read"
     * })
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Groups({
     *     "user_write",
     * })
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     */
    private $password;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read","product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="Le nom de famille est obligatoire")
     * @Assert\Length(min=3, minMessage="Le nom de famille doit faire entre 3 et 255 caractères", max=255, maxMessage="Le nom de famille doit faire entre 3 et 255 caractères")
     */
    private $lastName;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(min=3, minMessage="Le prénom doit faire entre 3 et 255 caractères", max=255, maxMessage="Le prénom doit faire entre 3 et 255 caractères")
     */
    private $firstName;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdate;   

    

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $accountStatus;


    /**
     * 
     * @Groups({
     *     "user_read"
     * })
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="user_id")
     */
    private $products;

    /**
     * @Groups({
     *     "user_read"
     * })
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author")
     */
    private $comments;

    /**
     * @Groups({
     *     "user_read"
     * })
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="author")
     */
    private $messages;


    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $siren;

    /**
     * @Groups({
     *     "user_read"
     * })
     * @ORM\OneToMany(targetEntity=Bookmark::class, mappedBy="user_id")
     */
    private $bookmarks;

    /**
     * @Groups({
     *     "user_read"
     * })
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="customer")
     */
    private $orders;

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
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @Groups({
     *     "user_read", "product_read" ,"comment_read", "bookmark_read", "message_read", "order_read", "product_subresource", "comment_subresource",
     *     "user_write",
     * })
     * @ORM\Column(type="float", nullable=true)
     */
    private $numReviews;


    // END GEDMO

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    

   

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUserId($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUserId() === $this) {
                $product->setUserId(null);
            }
        }

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
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setAuthor($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAuthor() === $this) {
                $message->setAuthor(null);
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
            $bookmark->setUserId($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): self
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getUserId() === $this) {
                $bookmark->setUserId(null);
            }
        }

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
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }



    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getAccountStatus(): ?string
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(string $accountStatus): self
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getNumReviews(): ?float
    {
        return $this->numReviews;
    }

    public function setNumReviews(?float $numReviews): self
    {
        $this->numReviews = $numReviews;

        return $this;
    }


}
