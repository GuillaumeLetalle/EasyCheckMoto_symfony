<?php

namespace App\Entity;

use App\Repository\CTRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CTRepository::class)]
class CT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fin = null;

    #[ORM\Column(nullable: true)]
    private ?bool $freinage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $direction = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visibilite = null;

    #[ORM\Column(nullable: true)]
    private ?bool $eclairage_signalisation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pneumatique = null;

    #[ORM\Column(nullable: true)]
    private ?bool $carrosserie = null;

    #[ORM\Column(nullable: true)]
    private ?bool $mecanique = null;

    #[ORM\Column(nullable: true)]
    private ?bool $equipement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $pollution = null;

    #[ORM\Column(nullable: true)]
    private ?bool $niveau_sonore = null;

    #[ORM\Column(nullable: true)]
    private ?bool $moto_is_ok = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaires = null;

    #[ORM\ManyToOne(targetEntity: Moto::class, inversedBy: 'controle_techniques')]
    private ?moto $vehicule_controle = null;

    #[ORM\ManyToOne(targetEntity: Technicien::class, inversedBy: 'controle_techniques')]
    private ?Technicien $technicien_controle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    public function isFreinage(): ?bool
    {
        return $this->freinage;
    }

    public function setFreinage(?bool $freinage): static
    {
        $this->freinage = $freinage;

        return $this;
    }

    public function isDirection(): ?bool
    {
        return $this->direction;
    }

    public function setDirection(?bool $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function isVisibilite(): ?bool
    {
        return $this->visibilite;
    }

    public function setVisibilite(?bool $visibilite): static
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    public function isEclairageSignalisation(): ?bool
    {
        return $this->eclairage_signalisation;
    }

    public function setEclairageSignalisation(?bool $eclairage_signalisation): static
    {
        $this->eclairage_signalisation = $eclairage_signalisation;

        return $this;
    }

    public function isPneumatique(): ?bool
    {
        return $this->pneumatique;
    }

    public function setPneumatique(?bool $pneumatique): static
    {
        $this->pneumatique = $pneumatique;

        return $this;
    }

    public function isCarrosserie(): ?bool
    {
        return $this->carrosserie;
    }

    public function setCarrosserie(?bool $carrosserie): static
    {
        $this->carrosserie = $carrosserie;

        return $this;
    }

    public function isMecanique(): ?bool
    {
        return $this->mecanique;
    }

    public function setMecanique(?bool $mecanique): static
    {
        $this->mecanique = $mecanique;

        return $this;
    }

    public function isEquipement(): ?bool
    {
        return $this->equipement;
    }

    public function setEquipement(?bool $equipement): static
    {
        $this->equipement = $equipement;

        return $this;
    }

    public function isPollution(): ?bool
    {
        return $this->pollution;
    }

    public function setPollution(?bool $pollution): static
    {
        $this->pollution = $pollution;

        return $this;
    }

    public function isNiveauSonore(): ?bool
    {
        return $this->niveau_sonore;
    }

    public function setNiveauSonore(?bool $niveau_sonore): static
    {
        $this->niveau_sonore = $niveau_sonore;

        return $this;
    }

    public function isMotoIsOk(): ?bool
    {
        return $this->moto_is_ok;
    }

    public function setMotoIsOk(?bool $moto_is_ok): static
    {
        $this->moto_is_ok = $moto_is_ok;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getVehiculeControle(): ?moto
    {
        return $this->vehicule_controle;
    }

    public function setVehiculeControle(?moto $vehicule_controle): static
    {
        $this->vehicule_controle = $vehicule_controle;

        return $this;
    }

    public function getTechnicienControle(): ?Technicien
    {
        return $this->technicien_controle;
    }

    public function setTechnicienControle(?Technicien $technicien_controle): static
    {
        $this->technicien_controle = $technicien_controle;

        return $this;
    }
}
