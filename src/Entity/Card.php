<?php

namespace App\Entity;

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
}
