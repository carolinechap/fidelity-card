<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    /**
     * @Route("/deal", name="deal")
     */
    public function index()
    {
        return $this->render('deal/index.html.twig', [
            'controller_name' => 'DealController',
        ]);
    }
}
