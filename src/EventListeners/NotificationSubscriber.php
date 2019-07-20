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
use App\Events\CardActivityEvent;
use App\Events\UserAccountEvent;
use Symfony\Component\Security\Core\Security;

class NotificationSubscriber implements EventSubscriberInterface
{
    private $logger;

    private $mailer;

    private $security;

    public function __construct(MailerService $mailer,
                                LoggerInterface $logger,
                                Security $security)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.ordering_workflow.completed.to_activating' => 'onCardActivated',
            'workflow.ordering_workflow.completed.to_deactivating' => 'onCardDeactivated',
            AppEvents::USER_ACCOUNT_CREATED =>  'onUserAccountCreated',
            AppEvents::CARD_NEW_ACTIVITY => 'onNewCardActivity',
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

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifCreatedUserAccount($user);
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
     * @param CardActivityEvent $event
     */
    public function onNewCardActivity(CardActivityEvent $event)
    {
        $cardActivity = $event->getCardActivity();

        $this->logger->info('Ajout nouvelle activité ');

        /*Notification au client - MAIL (Notification push) */
        $this->mailer->notifNewCardActivity($cardActivity);
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
        $this->mailer->notifFidelityPoint($card);
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