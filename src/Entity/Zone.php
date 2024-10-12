<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Categories>
     */
    #[ORM\OneToMany(targetEntity: Categories::class, mappedBy: 'zone')]
    private Collection $categories;

    /**
     * @var Collection<int, Equipement>
     */
    #[ORM\OneToMany(targetEntity: Equipement::class, mappedBy: 'zoneActu')]
    private Collection $equipements;

    /**
     * @var Collection<int, Emplacements>
     */
    #[ORM\OneToMany(targetEntity: Emplacements::class, mappedBy: 'zone')]
    private Collection $emplacements;

    /**
     * @var Collection<int, Historiques>
     */
    #[ORM\OneToMany(targetEntity: Historiques::class, mappedBy: 'zone')]
    private Collection $historiques;

    /**
     * @var Collection<int, Rayons>
     */
    #[ORM\OneToMany(targetEntity: Rayons::class, mappedBy: 'zone')]
    private Collection $rayons;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->emplacements = new ArrayCollection();
        $this->historiques = new ArrayCollection();
        $this->rayons = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setZone($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getZone() === $this) {
                $category->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): static
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->setZoneActu($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): static
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getZoneActu() === $this) {
                $equipement->setZoneActu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Emplacements>
     */
    public function getEmplacements(): Collection
    {
        return $this->emplacements;
    }

    public function addEmplacement(Emplacements $emplacement): static
    {
        if (!$this->emplacements->contains($emplacement)) {
            $this->emplacements->add($emplacement);
            $emplacement->setZone($this);
        }

        return $this;
    }

    public function removeEmplacement(Emplacements $emplacement): static
    {
        if ($this->emplacements->removeElement($emplacement)) {
            // set the owning side to null (unless already changed)
            if ($emplacement->getZone() === $this) {
                $emplacement->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Historiques>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historiques $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setZone($this);
        }

        return $this;
    }

    public function removeHistorique(Historiques $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getZone() === $this) {
                $historique->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rayons>
     */
    public function getRayons(): Collection
    {
        return $this->rayons;
    }

    public function addRayon(Rayons $rayon): static
    {
        if (!$this->rayons->contains($rayon)) {
            $this->rayons->add($rayon);
            $rayon->setZone($this);
        }

        return $this;
    }

    public function removeRayon(Rayons $rayon): static
    {
        if ($this->rayons->removeElement($rayon)) {
            // set the owning side to null (unless already changed)
            if ($rayon->getZone() === $this) {
                $rayon->setZone(null);
            }
        }

        return $this;
    }
}
