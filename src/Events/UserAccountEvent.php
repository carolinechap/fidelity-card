<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:45
 */

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;

class UserAccountEvent extends Event
{
    public const NAME = 'user.account';

    /** @var User */
    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}