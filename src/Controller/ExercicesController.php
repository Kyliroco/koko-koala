<?php

namespace App\Controller;

use App\Repository\ExerciceRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExercicesController extends AbstractController
{

    // #[Route('/exercices', name: 'app_exercices')]
    // public function enfantDashboard(): Response
    // {
    //     return $this->redirectToRoute('app_enfant');
    // }
    #[Route('/exercices/{exoId}/{niveauId}', name: 'exo')]
    public function index($exoId = null, $niveauId = null, ExerciceRepository $exerciceRepository): Response
    {
        $exercice = $exerciceRepository->find($exoId);
        $niveau = null;
        foreach($exercice->getNiveaux() as $n){
            if($n->getNumero() == $niveauId){$niveau = $n;break;}
        }
        if ($exercice === null || $niveau === null) {
            return $this->redirectToRoute('app_enfant');
        } else {
            // try {
            return $this->render('exercices/template.html.twig', [
                "exercice" => $exercice,
                "niveau" => $niveauId,
            ]);
            // } catch (Exception $e) {
            //     return $this->redirectToRoute('app_enfant');
            // }
        }
    }
}
