<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"card_listening:read"}},
 *     attributes={
 *          "pagination_items_per_page"=5
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 * @ApiFilter(OrderFilter::class, properties={"personalScore": "ASC", "countVictory": "ASC"})
 * @ApiFilter(RangeFilter::class, properties={"personalScore"})
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"card_listening:read"})
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
     * @Groups({"card_listening:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="card")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="SET NULL")
     * @Groups({"card_listening:read"})
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
     * @Groups({"card_listening:read"})
     */
    private $activities;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fidelityPoint;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"card_listening:read"})
     */
    private $personalScore;

    /**
     * @var integer
     */
    private $countVictory;

    /**
     * @var integer
     */
    private $countGames;


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

    public function getCardOwnerName()
    {
        return $this->customerCode . ' - ' . $this->getUser()->getFullName();
    }

    public function getFidelityPoint(): ?int
    {
        return $this->fidelityPoint;
    }

    public function setFidelityPoint(?int $fidelityPoint): self
    {
        $this->fidelityPoint = $fidelityPoint;

        return $this;
    }

    public function getPersonalScore(): ?int
    {
        return $this->personalScore;
    }

    public function setPersonalScore(?int $personalScore): self
    {
        $this->personalScore = $personalScore;

        return $this;
    }


    /**
     * @return int
     */
    public function getCountGamePlayed(){
        $game = 0;

        $games = $this->getActivities();

        foreach ($games as $g){
            $game += 1;
        }
        return $game;
    }


    /**
     * @return int
     */
    public function getCountWonGame(){
        $activities = $this->getActivities();
        $victories = 0;

        foreach ($activities as $activity){
            if($activity->getIsTheWinner() ==  true ){
                $victories += 1;
            }
        }
            return $victories;
        }

    /**
     * @return int
     * @Groups({"card_listening:read"})
     */
    public function getCountVictory(): int
    {
        return $this->getCountWonGame();
    }

    /**
     * @return int
     * @Groups({"card_listening:read"})
     */
    public function getCountGames(): int
    {
        return $this->getCountGamePlayed();
    }




}
