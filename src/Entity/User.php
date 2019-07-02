<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
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
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="L'email n'est pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     * @Assert\Length(min="6", minMessage="Le mot de passe doit faire au moins {{ limit }} caractères")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(max="6", maxMessage="Le numéro de rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $numberStreet;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(max="150", maxMessage="Le nom de la rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $nameStreet;

    /**
     * @ORM\Column(type="string", nullable=true, length=20)
     * @Assert\Length(max="20", maxMessage="Le code postal ne doit pas dépasser {{ limit }} caractères")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100", maxMessage="La ville ne doit pas dépasser {{ limit }} caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100", maxMessage="Le pays ne doit pas dépasser {{ limit }} caractères")
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $customerCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="Le prénom ne doit pas dépasser {{ limit }} caractères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="Le nom ne doit pas dépasser {{ limit }} caractères")
     */
    private $firstname;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store", inversedBy="users")
     */
    private $store;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="user")
     */
    private $card;

    public function __construct()
    {
        $this->store = new ArrayCollection();
        $this->card = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): bool
    {
        if(!in_array($role, $this->roles)) {
            $this->roles[] = $role;
            return true;
        } else {
            return false;
        }
    }

    public function removeRole(string $role): bool
    {
        if (($key = array_search($role, $this->roles)) !== false) {
            unset($this->roles[$key]);
            return true;
        } else {
            return false;
        }
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNumberStreet(): ?int
    {
        return $this->numberStreet;
    }

    public function setNumberStreet(?int $numberStreet): self
    {
        $this->numberStreet = $numberStreet;

        return $this;
    }

    public function getNameStreet(): ?string
    {
        return $this->nameStreet;
    }

    public function setNameStreet(?string $nameStreet): self
    {
        $this->nameStreet = $nameStreet;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCustomerCode(): ?int
    {
        return $this->customerCode;
    }

    public function setCustomerCode(?int $customerCode): self
    {
        $this->customerCode = $customerCode;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStore(): Collection
    {
        return $this->store;
    }

    public function addStore(Store $store): self
    {
        if (!$this->store->contains($store)) {
            $this->store[] = $store;
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        if ($this->store->contains($store)) {
            $this->store->removeElement($store);
        }

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
            $card->setUser($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->card->contains($card)) {
            $this->card->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getUser() === $this) {
                $card->setUser(null);
            }
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
