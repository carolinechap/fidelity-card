<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:45
 */

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\CardActivity;

/**
 * Class CardActivityEvent
 * @package App\Events
 */
class CardActivityEvent extends Event
{

    public const NAME = 'card.activity';

    /** @var CardActivity */
    protected $cardActivity;

    /**
     * CardActivityEvent constructor.
     * @param CardActivity $cardActivity
     */
    public function __construct(CardActivity $cardActivity)
    {
        $this->cardActivity = $cardActivity;
        $this->beforePoints = null;
    }

    /**
     * @return CardActivity|null
     */
    public function getCardActivity(): ?CardActivity
    {
        return $this->cardActivity;
    }

    /**
     * @return mixed
     */
    public function getNewActivity()
    {
        return $this->getCardActivity()->getActivity();
    }

    /**
     * @param $beforePoints
     * @return $this
     */
    public function setBeforePoints($beforePoints)
    {
        $this->beforePoints = $beforePoints;

        return $this;
    }

    /**
     * @return null
     */
    public function getBeforePoints()
    {
        return $this->beforePoints;
    }
}