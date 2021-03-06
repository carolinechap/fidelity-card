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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"card_listening:read"}},
 *     attributes={
 *          "pagination_client_enabled"=true,
 *          "pagination_items_per_page"=5,
 *          "pagination_fetch_join_collection"=true,
 *          "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
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
    private $status = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $checkSum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cards")
     * @Groups({"card_listening:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Store", inversedBy="cards")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="SET NULL")
     * @Groups({"card_listening:read"})
     */
    private $store;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Deal", inversedBy="cards")
     */
    private $deals;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max="6", maxMessage="card.customer_code.maxlength")
     */
    private $customerCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CardActivity", mappedBy="card")
     * @Groups({"card_listening:read"})
     */
    private $activities;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero(message="card.fidelity_point.positiveozero")
     */
    private $fidelityPoint;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"card_listening:read"})
     * @Assert\PositiveOrZero(message="card.personal_score.positiveozero")
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


    /**
     * Card constructor.
     */
    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->deals = new ArrayCollection();
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
    public function getStatus(): ?array
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return Card
     */
    public function setStatus(array $status): self
    {
        $this->status = $status;

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
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Card
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Store|null
     */
    public function getStore(): ?Store
    {
        return $this->store;
    }

    /**
     * @param Store|null $store
     * @return Card
     */
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

    /**
     * @param CardActivity $activity
     * @return Card
     */
    public function addActivity(CardActivity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setCard($this);
        }

        return $this;
    }

    /**
     * @param CardActivity $activity
     * @return Card
     */
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
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    /**
     * @param Deal $deal
     * @return Card
     */
    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals[] = $deal;
        }

        return $this;
    }

    /**
     * @param Deal $deal
     * @return Card
     */
    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->contains($deal)) {
            $this->deals->removeElement($deal);
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

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getStore()->getCenterCode() .
            $this->getCustomerCode() . $this->getCheckSum();

    }

    /**
     * @return string
     */
    public function getCardOwnerName()
    {
        return $this->getCode() . ' - ' . $this->getUser()->getFullName();
    }

    /**
     * @return int|null
     */
    public function getFidelityPoint(): ?int
    {
        return $this->fidelityPoint;
    }

    /**
     * @param int|null $fidelityPoint
     * @return Card
     */
    public function setFidelityPoint(?int $fidelityPoint): self
    {
        $this->fidelityPoint = $fidelityPoint;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPersonalScore(): ?int
    {
        return $this->personalScore;
    }

    /**
     * @param int|null $personalScore
     * @return Card
     */
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
