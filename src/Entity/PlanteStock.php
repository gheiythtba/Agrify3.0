<?php

namespace App\Entity;

use App\Repository\PlanteStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanteStockRepository::class)]
class PlanteStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPlante = null;

    #[ORM\Column(length: 255)]
    private ?string $etatPlante = null;

    #[ORM\Column]
    private ?float $quantitePlante = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntreeStock = null;

    #[ORM\ManyToOne(inversedBy: 'planteStock')]
    private ?Vente $vente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPlante(): ?string
    {
        return $this->nomPlante;
    }

    public function setNomPlante(string $nomPlante): static
    {
        $this->nomPlante = $nomPlante;

        return $this;
    }

    public function getEtatPlante(): ?string
    {
        return $this->etatPlante;
    }

    public function setEtatPlante(string $etatPlante): static
    {
        $this->etatPlante = $etatPlante;

        return $this;
    }

    public function getQuantitePlante(): ?float
    {
        return $this->quantitePlante;
    }

    public function setQuantitePlante(float $quantitePlante): static
    {
        $this->quantitePlante = $quantitePlante;

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
}
