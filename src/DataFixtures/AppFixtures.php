<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Classe;
use App\Entity\Exercice;
use App\Entity\Matiere;
use App\Entity\Niveau;
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

        $exo = new Exercice("MathsEx1", $this->getReference(2), $this->getReference(3), 1, "MathsEx1", $this->getReference(5));
        $this->addReference(6, $exo);
        $exo2 = new Exercice("FrançaisEx1", $this->getReference(1), $this->getReference(4), 0, "app_enfant", null);
        $exo3 = new Exercice("FrançaisEx2", $this->getReference(1), $this->getReference(3), 1, "app_enfant", null);
        $exo4 = new Exercice("Remplir une suite", $this->getReference(2), $this->getReference(3), 1, "RemplirSuite", $this->getReference(5));

        $exo5 = new Exercice("Décomposer", $this->getReference(2), $this->getReference(3), 1, "Decomposer", $this->getReference(5));

        $this->addReference(7, $exo4);
        $exo5 = new Exercice("Décomposer", $this->getReference(2), $this->getReference(3), 1, "Decomposer", $this->getReference(5));
        $this->addReference(8, $exo5);
        $exo6 = new Exercice("Compter", $this->getReference(2), $this->getReference(3), 1, "Compter", $this->getReference(5));
        $this->addReference(9, $exo6);
        $exo7 = new Exercice("Remplir une suite à l'envers", $this->getReference(2), $this->getReference(3), 1, "RemplirSuite", $this->getReference(5));
        $this->addReference(10, $exo7);
        $exo8 = new Exercice("Addition posés", $this->getReference(2), $this->getReference(3), 1, "Addition", $this->getReference(5));
        $this->addReference(11, $exo8);

        $manager->persist($exo);
        $manager->persist($exo2);
        $manager->persist($exo3);
        $manager->persist($exo4);
        $manager->persist($exo5);
        $manager->persist($exo6);
        $manager->persist($exo7);
        $manager->persist($exo8);
        $manager->flush();

        $niveau = new Niveau(1, $this->getReference(6), 1, 10, "Niveau 1");
        $niveau2 = new Niveau(2, $this->getReference(6), 1, 100, "Niveau 2");
        $niveau3 = new Niveau(1, $this->getReference(7), 1, 10, "Niveau 1");
        $niveau4 = new Niveau(2, $this->getReference(7), 1, 100, "Niveau 2");
        $niveau5 = new Niveau(1, $this->getReference(8), 1, 1000, "Niveau 1");
        $niveau6 = new Niveau(2, $this->getReference(8), 1000, 9999, "Niveau 2");
        $niveau7 = new Niveau(1, $this->getReference(9), 1, 10, "Niveau 1");
        $niveau8 = new Niveau(2, $this->getReference(9), 1, 50, "Niveau 2");
        $niveau9 = new Niveau(1, $this->getReference(10), 10, 1, "Niveau 1");
        $niveau10 = new Niveau(2, $this->getReference(10), 100, 1, "Niveau 2");
        $niveau11 = new Niveau(1, $this->getReference(11), 1, 100, "Niveau 1");
        $niveau12 = new Niveau(2, $this->getReference(11), 1, 1000, "Niveau 2");
        $manager->persist($niveau);
        $manager->persist($niveau2);
        $manager->persist($niveau3);
        $manager->persist($niveau4);
        $manager->persist($niveau5);
        $manager->persist($niveau6);
        $manager->persist($niveau7);
        $manager->persist($niveau8);
        $manager->persist($niveau9);
        $manager->persist($niveau10);
        $manager->persist($niveau11);
        $manager->persist($niveau12);
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
