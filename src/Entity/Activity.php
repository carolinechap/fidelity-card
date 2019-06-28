<?php

namespace App\Entity;

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
}
