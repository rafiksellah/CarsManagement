<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatesticController extends AbstractController
{
    /**
     * @Route("/dashboard/statestic", name="statestic")
     */
    public function index(): Response
    {
        return $this->render('statestic/index.html.twig', [
            'controller_name' => 'StatesticController',
        ]);
    }
}
