<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $usure = null;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    private ?Categories $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'equipements')]
    private ?Etat $etat = null;

    /**
     * @var Collection<int, Historiques>
     */
    #[ORM\OneToMany(targetEntity: Historiques::class, mappedBy: 'equipement')]
    private Collection $historiques;

    /**
     * @var Collection<int, EquipementEmprunte>
     */
    #[ORM\OneToMany(targetEntity: EquipementEmprunte::class, mappedBy: 'equipement')]
    private Collection $equipementEmpruntes;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
        $this->equipementEmpruntes = new ArrayCollection();
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

    public function getUsure(): ?int
    {
        return $this->usure;
    }

    public function setUsure(int $usure): static
    {
        $this->usure = $usure;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

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
            $historique->setEquipement($this);
        }

        return $this;
    }

    public function removeHistorique(Historiques $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getEquipement() === $this) {
                $historique->setEquipement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EquipementEmprunte>
     */
    public function getEquipementEmpruntes(): Collection
    {
        return $this->equipementEmpruntes;
    }

    public function addEquipementEmprunte(EquipementEmprunte $equipementEmprunte): static
    {
        if (!$this->equipementEmpruntes->contains($equipementEmprunte)) {
            $this->equipementEmpruntes->add($equipementEmprunte);
            $equipementEmprunte->setEquipement($this);
        }

        return $this;
    }

    public function removeEquipementEmprunte(EquipementEmprunte $equipementEmprunte): static
    {
        if ($this->equipementEmpruntes->removeElement($equipementEmprunte)) {
            // set the owning side to null (unless already changed)
            if ($equipementEmprunte->getEquipement() === $this) {
                $equipementEmprunte->setEquipement(null);
            }
        }

        return $this;
    }
}
