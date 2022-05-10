<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Classe;
use App\Entity\Exercice;
use App\Entity\Matiere;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $matiere = new Matiere("Français");
        $this->addReference(1, $matiere);
        $matiere2 = new Matiere("Mathématiques");
        $this->addReference(2, $matiere2);
        $manager->persist($matiere);
        $manager->persist($matiere2);
        $manager->flush();

        $classe = new Classe("CP");
        $this->addReference(3, $classe);
        $classe2 = new Classe("CE1");
        $this->addReference(4, $classe2);
        $manager->persist($classe);
        $manager->persist($classe2);
        $manager->flush();

        $categorie = new Categorie("Nombre et Calculs");
        $this->addReference(5, $categorie);
        $manager->persist($categorie);
        $manager->flush();

        $exo = new Exercice("MathsEx1", $this->getReference(2), $this->getReference(3), 0, "MathsEx1", $this->getReference(5));
        $exo2 = new Exercice("FrançaisEx1", $this->getReference(1), $this->getReference(4), 1, "app_enfant", null);
        $exo3 = new Exercice("FrançaisEx2", $this->getReference(1), $this->getReference(3), 0, "app_enfant", null);
        $exo4 = new Exercice("Remplir une suite", $this->getReference(2), $this->getReference(3), 0, "RemplirSuite", $this->getReference(5));
        $manager->persist($exo);
        $manager->persist($exo2);
        $manager->persist($exo3);
        $manager->persist($exo4);
        $manager->flush();

        //Mot de passe: testtest
        $user = new User(
            "Test",
            ["ROLE_PARENT", "ROLE_ENFANT"],
            "$2y$13$4saq9hX/1vS6XvV1eV6TYudeFXP0/.Mt.RRmKJqk9wOoe9TjWS70e",
            "testPrenom",
            "testNom",
            "test@test",
            "testVille",
            "testCodePostal",
            "Mme.",
            null
        );
        $user2 = new User(
            "testEnfant",
            ["ROLE_ENFANT"],
            "$2y$13$4saq9hX/1vS6XvV1eV6TYudeFXP0/.Mt.RRmKJqk9wOoe9TjWS70e",
            "testPrenom",
            "testNom",
            "test@test",
            "testVille",
            "testCodePostal",
            "",
            $this->getReference(3)
        );
        $user->addEnfant($user2);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();
    }
}
