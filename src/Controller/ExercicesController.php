<?php

namespace App\Controller;

use App\Repository\ExerciceRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExercicesController extends AbstractController
{

    #[Route('/exercices', name: 'app_exercices')]
    public function enfantDashboard(): Response
    {
        return $this->redirectToRoute('app_enfant');
    }
    #[Route('/exercices/{exoId}/{niveau}', name: 'exo')]
    public function index($exoId, $niveau, ExerciceRepository $exerciceRepository): Response
    {
        $exercice = $exerciceRepository->find($exoId);
        if ($exercice === null) {
            return $this->redirectToRoute('app_enfant');
        } else {
            // try {
            return $this->render('exercices/' . $exercice->getLien() . '.html.twig', [
                "exercice" => $exercice,
                "niveau" => $niveau,
            ]);
            // } catch (Exception $e) {
            //     return $this->redirectToRoute('app_enfant');
            // }
        }
    }
}
