<?php

namespace App\Entity;

use App\Repository\PlanteStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PlanteStockRepository::class)]
class PlanteStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message :"Le nom de la plante ne peut pas être vide.")]
    private ?string $nomPlante = null;

    #[ORM\Column(length: 255)]
    private ?string $etatPlante = null;

    #[ORM\Column(length: 255)]
    private ?string $health = null;

    #[ORM\Column]
    #[Assert\NotBlank(message :"La quantité de la plante ne peut pas être vide.")]
    #[Assert\Range(min: 0, notInRangeMessage: "La quantité ne doit pas être négative")]
    private ?float $quantitePlante = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntreeStock = null;

    #[ORM\ManyToOne(inversedBy: 'planteStock')]
    private ?Vente $vente = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide.")]
    #[Assert\Range(min: 0.01, notInRangeMessage: "Le prix doit être supérieur à {{ min }}.")]
    private ?float $prix =null;

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

    public function getHealth(): ?string
    {
        return $this->health;
    }

    public function setHealth(string $health): static
    {
        $this->health = $health;

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
