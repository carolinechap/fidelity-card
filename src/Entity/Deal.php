<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DealRepository")
 */
class Deal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="deal.name.blank")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(message="deal.startdate.valid")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(message="deal.enddate.valid")
     */
    private $endDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(maxMessage="deal.description.max", max="255", min="3", minMessage="deal.description.min")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="deal.cost_point.positive")
     * @Assert\Range(min=1, minMessage="deal.cost_point.min", max=10000, maxMessage="deal.cost_point.max")
     */
    private $costPoint;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card", mappedBy="deals")
     */
    private $cards;

    /**
     * Deal constructor.
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return Deal
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     * @return Deal
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     * @return Deal
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Deal
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCostPoint(): ?int
    {
        return $this->costPoint;
    }

    /**
     * @param int $costPoint
     * @return Deal
     */
    public function setCostPoint(int $costPoint): self
    {
        $this->costPoint = $costPoint;

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
     * @return Deal
     */
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->addDeal($this);
        }

        return $this;
    }

    /**
     * @param Card $card
     * @return Deal
     */
    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->removeDeal($this);
        }

        return $this;
    }
}
