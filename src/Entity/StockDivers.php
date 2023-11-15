<?php

namespace App\Entity;

use App\Repository\StockDiversRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockDiversRepository::class)]
class StockDivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomSD = null;

    #[ORM\Column]
    private ?float $quantiteSD = null;

    #[ORM\Column(length: 255)]
    private ?string $health = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntreeStock = null;

    #[ORM\ManyToOne(inversedBy: 'stockDivers')]
    private ?Vente $vente = null;

    #[ORM\Column]
    private ?float $prix =null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSD(): ?string
    {
        return $this->nomSD;
    }

    public function setNomSD(string $nomSD): static
    {
        $this->nomSD = $nomSD;

        return $this;
    }

    public function getQuantiteSD(): ?float
    {
        return $this->quantiteSD;
    }

    public function setQuantiteSD(float $quantiteSD): static
    {
        $this->quantiteSD = $quantiteSD;

        return $this;
    }

    public function getHealth(): ?string
    {
        return $this->health;
    }

    public function setHealth(string $health): static
    {
        $this->health = $health;

        return $this;
    }

    public function getDateEntreeStock(): ?\DateTimeInterface
    {
        return $this->dateEntreeStock;
    }

    public function setDateEntreeStock(\DateTimeInterface $dateEntreeStock): static
    {
        $this->dateEntreeStock = $dateEntreeStock;

        return $this;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): static
    {
        $this->vente = $vente;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
