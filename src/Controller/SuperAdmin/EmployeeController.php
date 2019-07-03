<?php


namespace App\Controller\SuperAdmin;

use App\Form\UserType;
use App\Repository\UserRepository;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EmployeeController
 * @package App\Controller\SuperAdmin
 * @Route("/employes")
 */
class EmployeeController extends AbstractController
{
    public function index(UserRepository $userRepository)
    {
        $employees = $userRepository->findBy([], ['roles' => 'ROLE_ADMIN']
        );

        return $this->render('superadmin/employees/index.html.twig', [
            $employees => 'employees'
        ]);
    }

    /**
     * @Route("/ajouter", name="superAdmin_createEmployee", methods={"GET", "POST"})
     */
    public function createEmployee(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $entityManager,
                             UserRequestHandler $userRequestHandler)
    {

        $user = new UserRequest();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $userRequestHandler->registerAsAdmin($user);
                $this->addFlash('success', 'Le compte de votre employé' . $user->getLastname() . ' ' . $user->getFirstname() . 'est créé');
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







}