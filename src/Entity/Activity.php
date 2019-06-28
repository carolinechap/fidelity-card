<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $personalScore;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fidelityPoint;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $gameDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isTheWinner;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card", mappedBy="activity")
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

    public function getPersonalScore(): ?int
    {
        return $this->personalScore;
    }

    public function setPersonalScore(?int $personalScore): self
    {
        $this->personalScore = $personalScore;

        return $this;
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

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(?\DateTimeInterface $gameDate): self
    {
        $this->gameDate = $gameDate;

        return $this;
    }

    public function getIsTheWinner(): ?bool
    {
        return $this->isTheWinner;
    }

    public function setIsTheWinner(?bool $isTheWinner): self
    {
        $this->isTheWinner = $isTheWinner;

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
            $card->addActivity($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            $card->removeActivity($this);
        }

        return $this;
    }
}
