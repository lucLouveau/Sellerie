<?php

namespace App\Entity;

use App\Repository\EquipementEmprunteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementEmprunteRepository::class)]
class EquipementEmprunte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'equipementEmpruntes')]
    private ?Equipement $equipement = null;

    #[ORM\ManyToOne(inversedBy: 'equipementEmpruntes')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
