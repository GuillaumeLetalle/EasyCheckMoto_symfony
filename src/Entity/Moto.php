<?php

namespace App\Entity;

use App\Repository\MotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotoRepository::class)]
class Moto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $modele = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $cylindree = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $annee = null;

    #[ORM\Column(length: 15)]
    private ?string $immatriculation = null;

    #[ORM\ManyToOne(inversedBy: 'motos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?client $client = null;

    #[ORM\OneToMany(mappedBy: 'vehicule_controle', targetEntity: CT::class)]
    private Collection $controle_techniques;

    public function __construct()
    {
        $this->controle_techniques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCylindree(): ?string
    {
        return $this->cylindree;
    }

    public function setCylindree(?string $cylindree): static
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, CT>
     */
    public function getControleTechniques(): Collection
    {
        return $this->controle_techniques;
    }

    public function addControleTechnique(CT $controleTechnique): static
    {
        if (!$this->controle_techniques->contains($controleTechnique)) {
            $this->controle_techniques->add($controleTechnique);
            $controleTechnique->setVehiculeControle($this);
        }

        return $this;
    }

    public function removeControleTechnique(CT $controleTechnique): static
    {
        if ($this->controle_techniques->removeElement($controleTechnique)) {
            // set the owning side to null (unless already changed)
            if ($controleTechnique->getVehiculeControle() === $this) {
                $controleTechnique->setVehiculeControle(null);
            }
        }

        return $this;
    }
}
