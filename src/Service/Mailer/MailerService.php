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

/**
 * Class MailerService
 * @package App\Service\Mailer
 */
class MailerService
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * MailerService constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     * @param TranslatorInterface $translator
     */
    public function __construct(Swift_Mailer $mailer,
                                Environment $twig,
                                TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * @param $subject
     * @param $to
     * @param $body
     * @return int
     */
    public function sendEmailAction($subject, $to, $body)
    {
        $message = $this->mailer->createMessage();

        $message->setSubject($subject);
        $message->setFrom("dispatch@mail.com");
        $message->setTo($to);
        $message->setBody($body);

        return $this->mailer->send($message);
    }

    # Send email when user is created

    /**
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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

    # Send email when new card is added to user account

    /**
     * @param Card $card
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifAddCard(Card $card)
    {
        $subject = $this->translator->trans('user.card.added', ['%number_card%' => $card->getCode()], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => 'user.card.added',
                'card' => $card,
                'user' => $card->getUser(),
                'subject' => $subject
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    # Send email when lost card is deactivated

    /**
     * @param Card $card
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifLostCard(Card $card)
    {
        $subject = $this->translator->trans('user.card.deactivated', ['%number_card%' => $card->getCode()], 'mail');
        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => 'user.card.deactivated',
                'card' => $card,
                'subject' => $subject,
                'user' => $card->getUser()
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    # Send email when a new card activity is created

    /**
     * @param CardActivity $cardActivity
     * @param $beforePoints
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifNewCardActivity(CardActivity $cardActivity, $beforePoints)
    {
        $subject = $this->translator->trans('card.new.activity', ['%activity%' => $cardActivity->getActivity()], 'mail');
        $to = $cardActivity->getCard()->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => AppEvents::CARD_NEW_ACTIVITY,
                'cardActivity' => $cardActivity,
                'subject' => $subject,
                'user' => $cardActivity->getCard()->getUser(),
                'before_points' => $beforePoints,
                'after_points' => $cardActivity->getCard()->getFidelityPoint()
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

    # Send email when fidelity points >= 500

    /**
     * @param Card $card
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notifFidelityPoints(Card $card)
    {
        $subject = $this->translator->trans('card.fidelity_points', [], 'mail');

        $to = $card->getUser()->getEmail();
        $body = $this->twig->render(
            'mail/mail.html.twig', [
                'type_notification' => 'card.fidelity_points',
                'card' => $card,
                'subject' => $subject,
                'user' => $card->getUser(),
                'fidelity_points' => $card->getFidelityPoint()
            ]
        );
        $this->sendEmailAction($subject, $to, $body);
    }

}