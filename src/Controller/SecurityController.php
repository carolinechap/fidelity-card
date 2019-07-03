<?php

namespace App\Controller;

use App\Entity\User;
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

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="signup_route", methods={"GET", "POST"})
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $entityManager,
                            UserRequestHandler $userRequestHandler)
    {

        $user = new UserRequest();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $userRequestHandler->registerAsUser($user);
                $this->addFlash('success', 'Votre compte est créé');
                return $this->redirectToRoute('login_route');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
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
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // TODO:Faire une condition pour savoir si l'utilisateur est déjà connecté
        // TODO: Voir pour un event qui écoutera le role -> permet de faire la redirection pour l'admin sur une page après connexion

        return $this->render('security/login.html.twig',[
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
