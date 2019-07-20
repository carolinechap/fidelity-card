<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 10:33
 */

namespace App\Events;

use App\Entity\Store;
use Symfony\Contracts\EventDispatcher\Event;
use App\Repository\UserRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StoreActivityEvent extends Event
{
    public const NAME = 'store.activity';

    /**
     * @return Store
     */
    public function getStoreOfEmployee($user,
                                       TranslatorInterface $translator,
                                       UserRepository $userRepository): Store
    {
        if (!$store = $userRepository->findStoreForEmployee($user)) {
            throw new HttpException(403,
                $translator->trans('access.forbidden', [], 'messages'));
        }
        return $store;
    }
}