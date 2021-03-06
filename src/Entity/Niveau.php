<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
#[ApiResource(
    attributes: [],
    collectionOperations: [
        "get",
        "post",
    ],
    itemOperations: [
        "get",
        "put",
    ],
    normalizationContext: ['groups' => ['niveau']]
)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("exercice", "matiere", "categorie", "classe",   "niveau")]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups("exercice", "matiere", "categorie", "classe",  "niveau")]
    private $numero;

    #[ORM\ManyToOne(targetEntity: Exercice::class, inversedBy: 'niveaux')]
    #[Groups("niveau")]
    private $exercice;

    #[ORM\Column(type: 'integer')]
    #[Groups("exercice", "matiere", "categorie", "classe",  "niveau")]
    private $min;

    #[ORM\Column(type: 'integer')]
    #[Groups("exercice", "matiere", "categorie", "classe",  "niveau")]
    private $max;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("exercice", "matiere", "categorie", "classe",  "niveau")]
    private $nom;



    public function getId(): ?int
    {
        return $this->id;
    }





    public function __construct($numero = null, $exercice = null, $min = null, $max = null, $nom = null)
    {
        $this->numero = $numero;
        $this->exercice = $exercice;
        $this->min = $min;
        $this->max = $max;
        $this->nom = $nom;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
