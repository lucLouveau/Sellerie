<?php

namespace App\Entity;

use App\Repository\MouvementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MouvementsRepository::class)]
class Mouvements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Historiques>
     */
    #[ORM\OneToMany(targetEntity: Historiques::class, mappedBy: 'mouvement')]
    private Collection $historiques;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
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
            $historique->setMouvement($this);
        }

        return $this;
    }

    public function removeHistorique(Historiques $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getMouvement() === $this) {
                $historique->setMouvement(null);
            }
        }

        return $this;
    }
}
