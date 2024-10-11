<?php

namespace App\Entity;

use App\Repository\HistoriquesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriquesRepository::class)]
class Historiques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'historiques')]
    private ?Mouvements $mouvement = null;

    #[ORM\ManyToOne(inversedBy: 'historiques')]
    private ?Zone $zone = null;

    #[ORM\ManyToOne(inversedBy: 'historiques')]
    private ?Equipement $equipement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMouvement(): ?Mouvements
    {
        return $this->mouvement;
    }

    public function setMouvement(?Mouvements $mouvement): static
    {
        $this->mouvement = $mouvement;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): static
    {
        $this->zone = $zone;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
