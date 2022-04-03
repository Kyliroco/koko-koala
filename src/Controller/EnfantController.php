<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnfantController extends AbstractController
{
    #[Route('/enfant', name: 'app_enfant')]
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        $exercices = $exerciceRepository->findAll();
        return $this->render('enfant/index.html.twig', [
            'exercices' => $exercices,
        ]);
    }
}
