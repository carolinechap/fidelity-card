<?php

namespace App\Controller;

use App\Form\UserType;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Events\AppEvents;
use App\Events\UserAccountEvent;

class SecurityController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @param UserRequestHandler $userRequestHandler
     * @param TranslatorInterface $translator
     * @param EventDispatcherInterface $eventDispatcher
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/inscription", name="signup_route", methods={"GET", "POST"})
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $entityManager,
                             UserRequestHandler $userRequestHandler,
                             TranslatorInterface $translator,
                             EventDispatcherInterface $eventDispatcher)
    {

        $user = new UserRequest();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $userRequestHandler->registerAsUser($user);

                //On déclenche l'événement correspondant
                $event = new UserAccountEvent($user);
                $eventDispatcher->dispatch($event, AppEvents::USER_ACCOUNT_CREATED);

                $this->addFlash('success', $translator->trans('registration.success', [], 'messages'));
                return $this->redirectToRoute('login_route');
            } else {
                $this->addFlash('error', $translator->trans('registration.failed', [], 'messages'));
            }

        }
        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView()
            ]
        );

    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     *
     * @Route("/connexion" , name="login_route")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );


    }

    /**
     * @Route("/deconnexion", name="logout_route")
     */
    public function logout()
    {

        //return $this->redirectToRoute('home');
    }
}
