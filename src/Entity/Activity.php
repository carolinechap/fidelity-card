<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
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
     * @Assert\Positive(message="activity.fidelitypoint.positive")
     */
    private $fidelityPoint;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CardActivity", mappedBy="activity")
     */
    private $cards;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="activity.gamename.blank")
     * @Assert\Length(max="100", maxMessage="activity.gamename.maxlength")
     * @Groups({"card_listening:read"})
     */
    private $gameName;


    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->gameName;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return mixed
     */
    public function getCards()
    {
        return $this->cards;
    }

    public function addCard(CardActivity $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setActivity($this);
        }

        return $this;
    }

    public function removeActivity(CardActivity $card): self
    {
        if($this->cards->contains($card)){
            $this->cards->remove($card);

            if($card->getActivity() === $this){
                $card->setActivity(null);
            }
        }
        return $this;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }





}
