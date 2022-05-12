<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [

        ]);
    }
    #[Route('/qui-sommes-nous', name: 'who_are_we')]
    public function whoAreWe(): Response
    {
        return $this->render('default/whoAreWe.html.twig', [

        ]);
    }
    #[Route('/demo', name: 'demo')]
    public function demo(): Response
    {
        return $this->render('exercices/demo2.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
