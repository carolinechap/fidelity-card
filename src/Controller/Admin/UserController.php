<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Repository\CardRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller\Admin
 * @Route("/admin/clients")
 */
class UserController extends AbstractController
{

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/" , name="admin_user_index")
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $users = $paginator->paginate($userRepository->searchByRoles((array)['ROLE_USER']), $request->query->getInt('page', 1),15);

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user, CardRepository $cardRepository, StoreRepository $storeRepository): Response
    {
        $cards = $cardRepository->findCardByUser($user);
        $stores = $storeRepository->findStoreByUser($user);

        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'cards' => $cards,
            'stores' => $stores
        ]);
    }

}