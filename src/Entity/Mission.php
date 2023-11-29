<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    private ?Classe $classe = null;

    #[ORM\OneToOne(mappedBy: 'mdj', cascade: ['persist', 'remove'])]
    private ?Classe $mdjclasse = null;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Historique::class)]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMdjclasse(): ?Classe
    {
        return $this->mdjclasse;
    }

    public function setMdjclasse(?Classe $mdjclasse): static
    {
        // unset the owning side of the relation if necessary
        if ($mdjclasse === null && $this->mdjclasse !== null) {
            $this->mdjclasse->setMdj(null);
        }

        // set the owning side of the relation if necessary
        if ($mdjclasse !== null && $mdjclasse->getMdj() !== $this) {
            $mdjclasse->setMdj($this);
        }

        $this->mdjclasse = $mdjclasse;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setMission($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getMission() === $this) {
                $historique->setMission(null);
            }
        }

        return $this;
    }

}
