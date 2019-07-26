<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:30
 */

namespace App\EventListeners;

use App\Service\Mailer\MailerService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event as WorkflowEvent;
use App\Events\AppEvents;
use App\Events\CardActivityEvent;
use App\Events\UserAccountEvent;
use App\Events\CardFidelityPointEvent;
use Symfony\Component\Security\Core\Security;

/**
 * Class NotificationSubscriber
 * @package App\EventListeners
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MailerService
     */
    private $mailer;

    /**
     * @var Security
     */
    private $security;

    /**
     * NotificationSubscriber constructor.
     * @param MailerService $mailer
     * @param LoggerInterface $logger
     * @param Security $security
     */
    public function __construct(MailerService $mailer,
                                LoggerInterface $logger,
                                Security $security)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->security = $security;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.card_status.completed.to_activating' => 'onCardActivated',
            'workflow.card_status.completed.to_deactivating' => 'onCardDeactivated',
            AppEvents::USER_ACCOUNT_CREATED => 'onUserAccountCreated',
            AppEvents::CARD_NEW_ACTIVITY => 'onNewCardActivity',
            AppEvents::CARD_FIDELITY_POINTS => 'onCardFidelityPoints'
        ];
    }

    /**
     * @param UserAccountEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onUserAccountCreated(UserAccountEvent $event)
    {
        $user = $event->getUser();

        /*Client push notification - Mail */
        $this->mailer->notifCreatedUserAccount($user);
    }

    /**
     * @param WorkflowEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onCardActivated(WorkflowEvent $event)
    {
        $card = $event->getSubject();

        /*Client push notification - Mail */
        $this->mailer->notifAddCard($card);
    }

    /**
     * @param WorkflowEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onCardDeactivated(WorkflowEvent $event)
    {
        $card = $event->getSubject();

        /*Client push notification - Mail */
        $this->mailer->notifLostCard($card);
    }

    /**
     * @param CardActivityEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onNewCardActivity(CardActivityEvent $event)
    {
        $cardActivity = $event->getCardActivity();
        $beforePoints = $event->getBeforePoints();

        /*Client push notification - Mail */
        $this->mailer->notifNewCardActivity($cardActivity, $beforePoints);
    }

    /**
     * @param CardFidelityPointEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onCardFidelityPoints(CardFidelityPointEvent $event)
    {
        $card = $event->getCard();

        $this->logger->info('Points de fidélité à 1000 : '
            . $card->getCode());

        /*Client push notification - Mail */
        $this->mailer->notifFidelityPoints($card);
    }

}