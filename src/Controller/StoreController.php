<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="store_index")
     */
    public function index(
        StoreRepository $storeRepository
    ) {
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/edition/{id}", name="store_edition",
     *     defaults={"id": null},
     *     requirements={"id": "\d+"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        $id
    ) {
        if (is_null($id)) { // création

            $store = new Store();
            $centerCode = $store->defineCenterCode();
            $store->setCenterCode($centerCode);
        } else { // modification
            $store = $em->find(Store::class, $id);

            // 404 si l'id n'est pas en bdd
            if (is_null($store)) {
                throw new NotFoundHttpException();
            }
        }

        // création du formulaire relié à la catégorie
        $form = $this->createForm(StoreType::class, $store);

        // le formulaire analyse la requête et fait le mapping
        // avec l'entité s'il a été soumis
        $form->handleRequest($request);

        dump($store);

        // si le formulaire a été soumis
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                               // enregistrement en bdd
                $em->persist($store);
                $em->flush();

                $this->addFlash('success', 'Le centre est enregistré');

                // redirection vers la liste
                return $this->redirectToRoute('store_index');
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }

        return $this->render(
            'store/edit.html.twig',
            [
                // passage du formulaire au template
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Store $store
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/suppression/{id}", name="store_delete")
     */
    public function delete(Store $store) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($store);
            $entityManager->flush();

            $this->addFlash('success', "Le magasin est supprimée");

        return $this->redirectToRoute('store_index');
    }
}

