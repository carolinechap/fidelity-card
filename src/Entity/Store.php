<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="store.center_code.positive")
     */
    private $centerCode;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="store.street_number.positive")
     */
    private $numberStreet;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="150", maxMessage="store.street_name.max")
     */
    private $nameStreet;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\Length(max="15", maxMessage="store.zip_code.max")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="store.city.max")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="store.country.max")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="store.name.max")
     * @Groups({"card_listening:read"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="stores")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="store", cascade={"persist"})
     */
    private $cards;

    /**
     * Store constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cards = new ArrayCollection();
        $this->centerCode = $this->defineCenterCode();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumberStreet(): ?int
    {
        return $this->numberStreet;
    }

    /**
     * @param int $numberStreet
     * @return Store
     */
    public function setNumberStreet(int $numberStreet): self
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
     * @param string $nameStreet
     * @return Store
     */
    public function setNameStreet(string $nameStreet): self
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
     * @param string $zipCode
     * @return Store
     */
    public function setZipCode(string $zipCode): self
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
     * @param string $city
     * @return Store
     */
    public function setCity(string $city): self
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
     * @param string $country
     * @return Store
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Store
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCenterCode()
    {
        return $this->centerCode;
    }

    /**
     * @param mixed $centerCode
     * @return Store
     */
    public function setCenterCode($centerCode)
    {
        $this->centerCode = $centerCode;
        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return Store
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addStore($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return Store
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeStore($this);
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
     * @return Store
     */
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setStore($this);
        }

        return $this;
    }

    /**
     * @param Card $card
     * @return Store
     */
    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getStore() === $this) {
                $card->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function defineCenterCode(){
        $randCode = mt_rand(1,999);
        $centerCode = sprintf("%03s",$randCode);

        return $centerCode;
    }
}
