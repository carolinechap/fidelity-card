<?php


namespace App\Controller\SuperAdmin;

use App\Form\SearchUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class EmployeeController
 * @package App\Controller\SuperAdmin
 * @Route("/gerant/employes")
 */
class EmployeeController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @Route("/" , name="superAdmin_indexEmployees")
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator)
    {
        // Search form
        $searchForm = $this->createForm(SearchUserType::class);
        $searchForm->handleRequest($request);

        $employees = $paginator->paginate($userRepository->searchCustomer((array)['ROLE_ADMIN'],(array) $searchForm->getData()), $request->query->getInt('page', 1),15);
        // Find the last record in db
        $lastRecord = $userRepository->findLastRecordByRole((array)['ROLE_ADMIN']);


        return $this->render('superadmin/employees/index.html.twig', [
            'employees' => $employees,
            'lastRecord' => $lastRecord,
            'search_form' => $searchForm->createView()
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
                $fullName = $user->getLastname() . ' ' . $user->getFirstname() ;
                $this->addFlash('success', "Le compte de votre employé $fullName est créé");
                return $this->redirectToRoute('admin_dashboard');
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