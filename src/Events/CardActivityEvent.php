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

class CardActivityEvent extends Event
{
    public const NAME = 'card.activity';

    /** @var CardActivity */
    protected $cardActivity;

    public function __construct(CardActivity $cardActivity)
    {
        $this->cardActivity = $cardActivity;
    }

    public function getCardActivity(): ?CardActivity
    {
        return $this->cardActivity;
    }

    public function getNewActivity()
    {
        return $this->getCardActivity()->getActivity();
    }
}