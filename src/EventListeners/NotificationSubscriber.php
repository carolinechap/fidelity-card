<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:30
 */

namespace App\EventListeners;

use App\Events\FidelityPointsEvent;
use App\Service\Mailer\MailerService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event as WorkflowEvent;
use App\Events\AppEvents;
use App\Events\UserActivityEvent;
use App\Events\UserAccountEvent;

class NotificationSubscriber implements EventSubscriberInterface
{
    private $logger;

    private $mailer;

    public function __construct(MailerService $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.ordering_workflow.completed.to_activating' => 'onCardActivated',
            'workflow.ordering_workflow.completed.to_deactivating' => 'onCardDeactivated',
            AppEvents::USER_ACCOUNT_CREATED =>  'onUserAccountCreated',
            AppEvents::USER_NEW_ACTIVITY => 'onNewUserActivity',
            AppEvents::STORE_NEW_ACTIVITY => 'onNewStoreActivity',
            AppEvents::CARD_FIDELITY_POINTS_CHANGED => 'onFidelityPointChanged',
        ];
    }

    /**
     * @param UserAccountEvent $event
     */
    public function onUserAccountCreated(UserAccountEvent $event)
    {
        $user = $event->getUser();

        $this->logger->info('Nouveau compte : '
            . $user->getLastname());

        /*Notification au client - MAIL (Notification push) */
//        $this->mailer->notifCreatedUserAccount($user);
    }

    /**
     * @param WorkflowEvent $event
     */
    public function onCardActivated(WorkflowEvent $event)
    {
        $card = $event->getSubject();

        $this->logger->info('Nouvelle carte activée : '
            . $card->getCompleteCode());

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifAddCard($card);
    }

    /**
     * @param WorkflowEvent $event
     */
    public function onCardDeactivated(WorkflowEvent $event)
    {
        $card = $event->getSubject();

        $this->logger->info('Carte désactivée : '
            . $card->getCompleteCode());

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifLostCard($card);
    }

    /**
     * @param UserActivityEvent $event
     */
    public function onNewUserActivity(UserActivityEvent $event)
    {
        $user = $event->getUser();

        $this->logger->info('Ajout nouvelle activité : '
            . $user->getLastname());

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifNewUserActivity($user);
    }

    /**
     * @param FidelityPointsEvent $event
     */
    public function onFidelityPointChanged(FidelityPointsEvent $event)
    {
        $card = $event->getCard();

        $this->logger->info('Points de fidélité changés : '
            . $card->getCompleteCode());

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifNewUserActivity($card);
    }

    /**
     * @param FidelityPointsEvent $event
     */
    public function onNewStoreActivity(FidelityPointsEvent $event)
    {
        $card = $event->getCard();

        $this->logger->info('Points de fidélité changés : '
            . $card->getCompleteCode());

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifNewUserActivity($card);
    }

}