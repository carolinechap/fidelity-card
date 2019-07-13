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
     */
    private $centerCode;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(max="6", maxMessage="Le numéro de rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $numberStreet;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="150", maxMessage="Le nom de la rue ne doit pas dépasser {{ limit }} caractères")
     */
    private $nameStreet;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\Length(max="20", maxMessage="Le code postal ne doit pas dépasser {{ limit }} caractères")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="La ville ne doit pas dépasser {{ limit }} caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="Le pays ne doit pas dépasser {{ limit }} caractères")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", maxMessage="Le nom ne doit pas dépasser {{ limit }} caractères")
     * @Groups({"card_listening:read"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="store")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="store", cascade={"persist"})
     */
    private $card;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->card = new ArrayCollection();
        $this->centerCode = $this->defineCenterCode();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberStreet(): ?int
    {
        return $this->numberStreet;
    }

    public function setNumberStreet(int $numberStreet): self
    {
        $this->numberStreet = $numberStreet;

        return $this;
    }

    public function getNameStreet(): ?string
    {
        return $this->nameStreet;
    }

    public function setNameStreet(string $nameStreet): self
    {
        $this->nameStreet = $nameStreet;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
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

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addStore($this);
        }

        return $this;
    }

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
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
            $card->setStore($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->card->contains($card)) {
            $this->card->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getStore() === $this) {
                $card->setStore(null);
            }
        }

        return $this;
    }

    public function defineCenterCode(){
        $randCode = mt_rand(1,999);
        $centerCode = sprintf("%03s",$randCode);

        return $centerCode;
    }
}
