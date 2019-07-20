<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:45
 */

namespace App\Events;

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Card;

class FidelityPointsEvent extends Event
{
    /** @var Card */
    protected $card;


    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(Card $card): self
    {
        $this->card = $card;

        return $this;
    }
}