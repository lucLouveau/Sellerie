<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::JSON)]
    private array $longitude = [];

    #[ORM\Column(type: Types::JSON)]
    private array $latitude = [];

    #[ORM\ManyToOne(inversedBy: 'zones')]
    private ?TypeZone $type = null;

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

    public function getLongitude(): array
    {
        return $this->longitude;
    }

    public function setLongitude(array $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): array
    {
        return $this->latitude;
    }

    public function setLatitude(array $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getType(): ?TypeZone
    {
        return $this->type;
    }

    public function setType(?TypeZone $type): static
    {
        $this->type = $type;

        return $this;
    }
}
