<?php


namespace App\Controller\SuperAdmin;

use App\Entity\User;
use App\Form\SearchUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\User\UserRequest;
use App\User\UserRequestHandler;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EmployeeController
 * @package App\Controller\SuperAdmin
 * @Route("/dashboards/employes")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/" , name="superAdmin_indexEmployees")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,
                          UserRepository $userRepository,
                          PaginatorInterface $paginator)
    {
        // Search form
        $searchForm = $this->createForm(SearchUserType::class);
        $searchForm->handleRequest($request);

        $employees = $paginator->paginate($userRepository->searchUser((array)['ROLE_ADMIN'], (array)$searchForm->getData()), $request->query->getInt('page', 1), 15);
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @param UserRequestHandler $userRequestHandler
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function createEmployee(Request $request,
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
                $user = $userRequestHandler->registerAsAdmin($user);
                $this->addFlash('success', $translator->trans('new.success', [], 'crud'));
                return $this->redirectToRoute('crud_dashboard');
            } else {
                $this->addFlash('error', $translator->trans('new.error', [], 'crud'));
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
     * @Route("/suppression/{id}", name="superAdmin_deleteEmployee", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @param User $user
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function delete(EntityManagerInterface $entityManager,
                           User $user, TranslatorInterface $translator): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', $translator->trans('remove.success', [], 'crud'));

        return $this->redirectToRoute('superAdmin_indexEmployees');
    }



}