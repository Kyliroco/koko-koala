<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
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
    normalizationContext: ['groups' => ['exercice']]
)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("exercice", "categorie", "matiere", "classe", "niveau")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("exercice", "categorie", "matiere", "classe", "niveau")]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'exercices')]
    #[Groups("exercice", "categorie",  "classe", "niveau")]
    private $matiere;


    #[ORM\Column(type: 'boolean')]
    #[Groups("exercice", "categorie", "matiere", "classe", "niveau")]
    private $visible;

    #[ORM\Column(type: 'string', length: 255)]
    private $lien;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'exercices')]
    #[Groups("exercice", "categorie", "matiere", "niveau")]
    private $classe;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'exercices')]
    #[Groups("exercice", "matiere", "classe", "niveau")]
    private $categorie;

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: Niveau::class)]
    #[Groups("exercice", "categorie", "matiere",  "classe")]
    private $niveaux;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }



    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    function __construct($nom, $matiere, $classe, $visible, $lien, $categorie)
    {
        $this->nom = $nom;
        $this->matiere = $matiere;
        $this->classe = $classe;
        $this->visible = $visible;
        $this->lien = $lien;
        $this->categorie = $categorie;
        $this->niveaux = new ArrayCollection();
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom;
    }

    /**
     * @return Collection<int, Niveau>
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setExercice($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getExercice() === $this) {
                $niveau->setExercice(null);
            }
        }

        return $this;
    }
}
