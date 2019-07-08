<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CardActivity
 * @ORM\Entity
 * @ORM\Table(name="card_activity")
 */
class CardActivity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $isTheWinner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $personalScore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="activities")
     */
    private $card;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="cards")
     */
    private $activity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     * @return CardActivity
     */
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     * @return CardActivity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getIsTheWinner()
    {
        return $this->isTheWinner;
    }

    /**
     * @param mixed $isTheWinner
     * @return CardActivity
     */
    public function setIsTheWinner($isTheWinner)
    {
        $this->isTheWinner = $isTheWinner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalScore()
    {
        return $this->personalScore;
    }

    /**
     * @param mixed $personalScore
     * @return CardActivity
     */
    public function setPersonalScore($personalScore)
    {
        $this->personalScore = $personalScore;
        return $this;
    }





}