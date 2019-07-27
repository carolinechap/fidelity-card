<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 10:33
 */

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Card;

/**
 * Class CardFidelityPointEvent
 * @package App\Events
 */
class CardFidelityPointEvent extends Event
{
    /**
     *
     */
    public const NAME = 'card.fidelity_point';

    /** @var Card */
    protected $card;

    /**
     * CardEvent constructor.
     * @param Card $card
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    /**
     * @return Card|null
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }

    /**
     * @return bool
     */
    public function fidelityPointsAttained()
    {
        return $this->getCard()->getFidelityPoint() >= 1000;
    }
}