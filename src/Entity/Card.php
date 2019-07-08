<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
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
    private $statut = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $checkSum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="card")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="card")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $store;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Deal", inversedBy="cards")
     */
    private $deal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $customerCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CardActivity", mappedBy="card")
     */
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->deal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?array
    {
        return $this->statut;
    }

    public function setStatut(array $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCheckSum()
    {
        return $this->checkSum;
    }

    /**
     * @param mixed $checkSum
     * @return Card
     */
    public function setCheckSum($checkSum)
    {
        $this->checkSum = $checkSum;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivities()
    {
        return $this->activities;
    }

    public function addActivity(CardActivity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setCard($this);
        }

        return $this;
    }

    public function removeActivity(CardActivity $activity): self
    {
        if($this->activities->contains($activity)){
            $this->activities->remove($activity);

            if($activity->getCard() === $this){
                $activity->setCard(null);
            }
        }
        return $this;
    }


    /**
     * @return Collection|Deal[]
     */
    public function getDeal(): Collection
    {
        return $this->deal;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deal->contains($deal)) {
            $this->deal[] = $deal;
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deal->contains($deal)) {
            $this->deal->removeElement($deal);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * @param mixed $customerCode
     * @return Card
     */
    public function setCustomerCode($customerCode): self
    {
        $this->customerCode = $customerCode;
        return $this;
    }

    public function getCode(): int
    {
        return $this->getStore()->getCenterCode() .
            $this->getCustomerCode() . $this->getCheckSum();
    }



}
