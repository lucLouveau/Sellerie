<?php

namespace App\Entity;

use App\Repository\EmplacementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmplacementsRepository::class)]
class Emplacements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $etage = null;

    #[ORM\Column]
    private ?int $colone = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipement $equipement = null;

    #[ORM\ManyToOne(inversedBy: 'emplacements')]
    private ?Rayons $rayon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): static
    {
        $this->etage = $etage;

        return $this;
    }

    public function getColone(): ?int
    {
        return $this->colone;
    }

    public function setColone(int $colone): static
    {
        $this->colone = $colone;

        return $this;
    }

    public function getEquipement(): ?Equipement
    {
        return $this->equipement;
    }

    public function setEquipement(?Equipement $equipement): static
    {
        $this->equipement = $equipement;

        return $this;
    }

    public function getRayon(): ?Rayons
    {
        return $this->rayon;
    }

    public function setRayon(?Rayons $rayon): static
    {
        $this->rayon = $rayon;

        return $this;
    }
}
