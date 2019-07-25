<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberStreet;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $nameStreet;

    /**
     * @ORM\Column(type="string", nullable=true, length=20)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"card_listening:read"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"card_listening:read"})
     */
    private $firstname;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store", inversedBy="users")
     */
    private $stores;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="user")
     */
    private $cards;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->stores = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function addRole(string $role): bool
    {
        if(!in_array($role, $this->roles)) {
            $this->roles[] = $role;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $role
     * @return bool
     */
    public function removeRole(string $role): bool
    {
        if (($key = array_search($role, $this->roles)) !== false) {
            unset($this->roles[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberStreet(): ?int
    {
        return $this->numberStreet;
    }

    /**
     * @param int|null $numberStreet
     * @return User
     */
    public function setNumberStreet(?int $numberStreet): self
    {
        $this->numberStreet = $numberStreet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNameStreet(): ?string
    {
        return $this->nameStreet;
    }

    /**
     * @param string|null $nameStreet
     * @return User
     */
    public function setNameStreet(?string $nameStreet): self
    {
        $this->nameStreet = $nameStreet;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string|null $zipCode
     * @return User
     */
    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return User
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return User
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    /**
     * @param Store $store
     * @return User
     */
    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
        }

        return $this;
    }

    /**
     * @param Store $store
     * @return User
     */
    public function removeStore(Store $store): self
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
        }

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    /**
     * @param Card $card
     * @return User
     */
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setUser($this);
        }

        return $this;
    }

    /**
     * @param Card $card
     * @return User
     */
    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }



    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }
}
