<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CardActivity
 * @ApiResource(
 *     shortName="cardactivity",
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 * )
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
     * @ORM\Column(type="boolean", length=150, nullable=true)
     */
    private $isTheWinner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive(message="cardActivity.personalscore.positive")
     */
    private $personalScore;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(message="cardActivity.gamedate.valid")
     * @Assert\LessThan("tomorrow", message="cardActivity.gamedate.lessthan")
     */
    private $gameDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="activities")
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id", nullable=false)})
     */
    private $card;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="cards", cascade={"persist"})
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     * @Groups({"card_listening:read"})

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

    /**
     * @return mixed
     */
    public function getGameDate()
    {
        return $this->gameDate;
    }

    /**
     * @param mixed $gameDate
     * @return CardActivity
     */
    public function setGameDate($gameDate)
    {
        $this->gameDate = $gameDate;
        return $this;
    }







}