<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    /**
     * @var Collection<int, Etudiant>
     */
    #[ORM\OneToMany(targetEntity: Etudiant::class, mappedBy: 'classe')]
    private Collection $NbEtudiant;

    public function __construct()
    {
        $this->NbEtudiant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getNbEtudiant(): Collection
    {
        return $this->NbEtudiant;
    }

    public function addNbEtudiant(Etudiant $nbEtudiant): static
    {
        if (!$this->NbEtudiant->contains($nbEtudiant)) {
            $this->NbEtudiant->add($nbEtudiant);
            $nbEtudiant->setClasse($this);
        }

        return $this;
    }

    public function removeNbEtudiant(Etudiant $nbEtudiant): static
    {
        if ($this->NbEtudiant->removeElement($nbEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($nbEtudiant->getClasse() === $this) {
                $nbEtudiant->setClasse(null);
            }
        }

        return $this;
    }
}
