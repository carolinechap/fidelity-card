<?php


namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\SearchUserType;
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
 * @Route("dashboards/clients")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/" , name="admin_user_index")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,
                          UserRepository $userRepository,
                          PaginatorInterface $paginator)
    {
        $searchForm = $this->createForm(SearchUserType::class);
        $searchForm->handleRequest($request);

        $users = $paginator->paginate($userRepository->searchUser((array)['ROLE_USER'], (array)$searchForm->getData()), $request->query->getInt('page', 1), 15);

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'search_form' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     * @param User $user
     * @param CardRepository $cardRepository
     * @param StoreRepository $storeRepository
     * @return Response
     */
    public function show(User $user,
                         CardRepository $cardRepository,
                         StoreRepository $storeRepository): Response
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