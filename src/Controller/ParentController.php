<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddEnfantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ParentController extends AbstractController
{
    #[Route('/parent', name: 'app_parent')]
    public function index(Request $request): Response
    {
        return $this->render('parent/index.html.twig', [
            'controller_name' => 'ParentController',
            'registration' => $request->get('registration')
        ]);
    }
    #[Route('/parent/enfants/ajout', name: 'ajout_enfant')]
    public function ajout_enfant(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AddEnfantType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_ENFANT"]);
            $user->setCodePostal($this->getUser()->getCodePostal());
            $user->setMail($this->getUser()->getMail());
            $user->setVille($this->getUser()->getVille());
            $this->getUser()->addEnfant($user);

            $entityManager->persist($user);
            $entityManager->persist($this->getUser());
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_parent', array("registration" => true));
        }

        return $this->render('parent/ajoutEnfant.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
