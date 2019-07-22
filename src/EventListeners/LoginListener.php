<?php


namespace App\EventListeners;


use ApiPlatform\Core\Api\UrlGeneratorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginListener
 * @package App\EventListeners
 */
class LoginListener implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Security
     */
    private $security;

    /**
     * LoginListener constructor.
     * @param UrlGeneratorInterface $router
     * @param LoggerInterface $logger
     * @param EventDispatcherInterface $eventDispatcher
     * @param Security $security
     */
    public function __construct(UrlGeneratorInterface $router, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher, Security $security)
    {
        $this->router = $router;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
        $this->security = $security;

    }

    /**
     * @param ResponseEvent $responseEvent
     */
    public function onKernelResponse(ResponseEvent $responseEvent){

        //this->logger->info('ok');

        if ($this->security->isGranted('ROLE_ADMIN') or $this->security->isGranted('ROLE_SUPERADMIN')) {
            $responseEvent->setResponse(new RedirectResponse($this->router->generate('crud_dashboard')));
        } else {
            $responseEvent->setResponse(new RedirectResponse($this->router->generate('home')));
        }
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event){

       $this->eventDispatcher->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);

    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
           'security.interactive_login' => ['onSecurityInteractiveLogin']
        ];

    }
}