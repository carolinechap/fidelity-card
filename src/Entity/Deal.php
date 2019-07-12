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
     * @todo assert for costPoint range ?
     */
    private $costPoint;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card", mappedBy="deals")
     */
    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCostPoint(): ?int
    {
        return $this->costPoint;
    }

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

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->addDeal($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->removeDeal($this);
        }

        return $this;
    }
}
