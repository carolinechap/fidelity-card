<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StoreController
 * @package App\Controller
 * @Route("/centre")
 */
class StoreController extends AbstractController
{
    /**
     * @param StoreRepository $storeRepository
     * @return Response
     *
     * @Route("/", name="store_index")
     */
    public function index(
        StoreRepository $storeRepository
    )
    {
        $stores = $storeRepository->findBy(
            [],
            [
                'name' => 'DESC'
            ]
        );
        return $this->render(
            'store/index.html.twig',
            [
                'stores' => $stores
            ]
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @return RedirectResponse|Response
     * @Route("/edition/{id}", name="store_edition",
     *     defaults={"id": null},
     *     requirements={"id": "\d+"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        $id
    )
    {
        if (is_null($id)) {
            // Create an store
            $store = new Store();
            $centerCode = $store->defineCenterCode();
            $store->setCenterCode($centerCode);
        } else {
            // Update
            $store = $em->find(Store::class, $id);

            // throw 404 if its not in db
            if (is_null($store)) {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(StoreType::class, $store);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $em->persist($store);
                $em->flush();

                $this->addFlash('success', 'Le centre est enregistré');

                return $this->redirectToRoute('store_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'store/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Store $store
     * @return RedirectResponse
     *
     * @Route("/suppression/{id}", name="store_delete")
     */
    public function delete(Store $store)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($store);
        $entityManager->flush();

        $this->addFlash('success', "Le magasin est supprimée");

        return $this->redirectToRoute('store_index');
    }
}

