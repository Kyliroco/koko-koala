<?php

namespace App\Controller;

use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExercicesController extends AbstractController
{
    #[Route('/exercices', name: 'app_exercices')]
    public function index(): Response
    {
        return $this->render('exercices/index.html.twig', [
            'controller_name' => 'ExercicesController',
        ]);
    }
    #[Route('/exercices/MathsEx1', name: 'MathsEx1')]
    public function MathsEx1(): Response
    {
        return $this->render('exercices/mathsEx1.html.twig', [
        ]);
    }
}
