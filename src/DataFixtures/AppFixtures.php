<?php

namespace App\DataFixtures;

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
        $matiere2 = new Matiere("Maths");
        $manager->persist($matiere);
        $manager->persist($matiere2);

        $niveau = new Niveau("CP");
        $niveau2 = new Niveau("CE1");
        $manager->persist($niveau);
        $manager->persist($niveau2);

        $exo = new Exercice("MathsEx1", $matiere2->getId(), $niveau->getId(), 0, "MathsEx1");
        $exo2 = new Exercice("FrançaisEx1", $matiere->getId(), $niveau->getId(), 1, "app_enfant");
        $exo3 = new Exercice("FrançaisEx2", $matiere->getId(), $niveau2->getId(), 0, "app_enfant");
        $exo4 = new Exercice("MathsEx2", $matiere2->getId(), $niveau2->getId(), 1, "app_enfant");
        $manager->persist($exo);
        $manager->persist($exo2);
        $manager->persist($exo3);
        $manager->persist($exo4);

        //Mot de passe: testtest
        $user = new User("Test", ["ROLE_PARENT", "ROLE_ENFANT"], "$2y$13$4saq9hX/1vS6XvV1eV6TYudeFXP0/.Mt.RRmKJqk9wOoe9TjWS70e",
                        "testPrenom", "testNom", "test@test", "testVille", "testCodePostal", "Mme.", "");

        $manager->persist($user);
        $manager->flush();
    }
}
