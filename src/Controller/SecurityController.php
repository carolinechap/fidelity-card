<?php

namespace App\Controller;

use App\Entity\User;
use App\EventListeners\LoginListener;
use App\Form\UserType;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="signup_route", methods={"GET", "POST"})
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $entityManager,
                             UserRequestHandler $userRequestHandler,
                             TranslatorInterface $translator)
    {

        $user = new UserRequest();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $userRequestHandler->registerAsUser($user);
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
