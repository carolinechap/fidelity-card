<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 09:43
 */

namespace App\Events;

/**
 * This class defines the names of all the events dispatched in
 * our project. It's not mandatory to create a
 * class like this, but it's considered a good practice.
 *
 */
final class AppEvents
{
    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("App\Events\StoreActivityEvent")
     * @Event("App\Events\UserAccountEvent")
     * @Event("App\Events\CardActivityEvent")
     * @Event("App\Events\FidelityPointsEvent")
     *
     * @var string
     */
    const USER_ACCOUNT_CREATED = 'user.account';
    const CARD_NEW_ACTIVITY = 'card.activity';
    const STORE_NEW_ACTIVITY = 'store.activity';
    const CARD_FIDELITY_POINTS_CHANGED = 'card.fidelity_points';
}