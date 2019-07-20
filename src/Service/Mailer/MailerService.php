<?php
/**
 * Created by PhpStorm.
 * User: Corinne
 * Date: 20/07/2019
 * Time: 07:18
 */

namespace App\Service\Mailer;

use App\Entity\User;
use Swift_Mailer;
use Twig\Environment;
use App\Entity\Card;
use App\Events\AppEvents;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\CardActivity;

class MailerService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    private $twig;

    private $translator;

    public function __construct(Swift_Mailer $mailer,
                                Environment $twig,
                                TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function sendEmailAction($subject, $to, $body)
    {
        $message = $this->mailer->createMessage();

        $message->setSubject($subject);
        $message->setFrom("dispatch@mail.com");
        $message->setTo($to);
        $message->setBody($body);

        return $this->mailer->send($message);

    }

    public function notifCreatedUserAccount(User $user)
    {
        $subject = $this->translator->trans('user.account.subject', [], 'mail');
        $to = $user->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => AppEvents::USER_ACCOUNT_CREATED,
                'subject' => $subject,
                'user' => $user
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifAddCard(Card $card)
    {
        $subject = $this->translator->trans('user.card.add', [], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => 'workflow.ordering_workflow.completed.to_activating',
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifLostCard(Card $card)
    {
        $subject = $this->translator->trans('user.card.deactivated', [], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => 'workflow.ordering_workflow.completed.to_deactivating',
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifNewStoreActivity(Card $card)
    {
        $subject = $this->translator->trans('store.new.activity', [], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::STORE_NEW_ACTIVITY,
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifNewCardActivity(CardActivity $cardActivity)
    {
        $subject = $this->translator->trans('card.new.activity', [], 'mail');
        $to = $cardActivity->getCard()->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::CARD_NEW_ACTIVITY,
                'card' => $cardActivity
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifFidelityPoint(Card $card)
    {
        $subject = $this->translator->trans('card.fidelity_points_changed', [], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::CARD_FIDELITY_POINTS_CHANGED,
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

}