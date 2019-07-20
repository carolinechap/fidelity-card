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

class MailerService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;
    private $twig;

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
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
        $subject = "Votre compte a été créé";
        $to = $user->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => AppEvents::USER_ACCOUNT_CREATED,
                'name' => $user->getLastname(). ' ' .$user->getFirstname(),
                'user' => $user
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifAddCard(Card $card)
    {
        $subject = "Nouvelle commande";
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => 'workflow.ordering_workflow.completed.to_activating',
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifLostCard(Card $card)
    {
        $subject = "Nouvelle commande";
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
        $subject = "Nouvelle commande";
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::CARD_NEW_ACTIVITY,
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifNewUserActivity(Card $card)
    {
        $subject = "Nouvelle commande";
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::USER_NEW_ACTIVITY,
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    public function notifFidelityPoint(Card $card)
    {
        $subject = "Nouvelle commande";
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/new_order.html.twig', [
                'type_notification' => AppEvents::CARD_FIDELITY_POINTS_CHANGED,
                'name' => $card->getUser()->getLastname(). ' ' .$card->getUser()->getFirstname(),
                'card' => $card
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

}