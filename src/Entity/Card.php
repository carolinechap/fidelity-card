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

    public function __construct()
    {
        $this->activity = new ArrayCollection();
        $this->deal = new ArrayCollection();
        //$this->store
        //$this->checkSum = $this->defineCheckSum();
        //$this->cardCode = $this->defineCardCode();
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

    /**
     * @return int
     */
    public function getCardCode(): int
    {
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

    public function defineCheckSum(){
        $centerCode =$this->getStore()->getCenterCode();
        $customerCode = $this->getUser()->getCustomerCode();

        $checkSum = ($centerCode+$customerCode)%9;


        return $checkSum;
    }
    public function defineCardCode()
    {
        $centerCode = $this->getStore()->getCenterCode();
        $customerCode = $this->getUser()->getCustomerCode();
        $checkSum = $this->checkSum;
        $cardCode = $centerCode . $customerCode . $checkSum;

        $cardCode = (int)$cardCode;

        return $cardCode;
    }
}
