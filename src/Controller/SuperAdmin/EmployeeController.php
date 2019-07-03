<?php


namespace App\Controller\SuperAdmin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmployeeController
 * @package App\Controller\SuperAdmin
 * @Route("/employe")
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






}