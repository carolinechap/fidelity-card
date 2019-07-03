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
     */
    private $store;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity", inversedBy="cards")
     */
    private $activity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Deal", inversedBy="cards")
     */
    private $deal;

    /**
     * @var integer
     */
    private $cardCode;

    /**
     * @return int
     */
    public function getCardCode(Card $card): int
    {
        $centerCode =$card->getStore()->getCenterCode();
        $customerCode = $card->getUser()->getCustomerCode();
        $checkSum = $card->getCheckSum();
        $cardCode = $centerCode . $customerCode . $checkSum;
        $this->cardCode =(int)$cardCode;

        return $this->cardCode;
    }

    /**
     * @param int $cardCode
     * @return Card
     */
    public function setCardCode(int $cardCode): Card
    {
        $this->cardCode = $cardCode;

        return $this;
    }

    public function __construct()
    {
        $this->activity = new ArrayCollection();
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

    public function getCheckSum(): ?int
    {
        return $this->checkSum;
    }

    public function setCheckSum(int $checkSum): self
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
     * @return Collection|Activity[]
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activity->contains($activity)) {
            $this->activity->removeElement($activity);
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
}
