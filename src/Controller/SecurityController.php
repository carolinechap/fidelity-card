<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
     * @Route("/inscription", name="signup_route")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                $password = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
                $user->setPassword($password);
                $entityManager->persist($user);
                $entityManager->flush();

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

        //dd($lastUsername);
        if (!empty($error)){
            $this->addFlash('error', 'Identifiants incorrects');

        }

        return $this->render('security/login.html.twig',[
                'last_username' => $lastUsername,
            ]
        );
    }

    /**
     * @Route("/deconnexion", name="logout_route")
     */
    public function logout()
    {

    }
}
