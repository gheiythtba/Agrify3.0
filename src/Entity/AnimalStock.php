<?php

namespace App\Entity;

use App\Repository\AnimalStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalStockRepository::class)]
class AnimalStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomAnimal = null;

    #[ORM\Column(length: 255)]
    private ?string $sexeAnimal = null;

    #[ORM\Column]
    private ?int $ageAnimal = null;

    #[ORM\Column]
    private ?float $poidsAnimal = null;

    #[ORM\Column(length: 255)]
    private ?string $health = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntreeStock = null;

    #[ORM\ManyToOne(inversedBy: 'animalStock')]
    private ?Vente $vente = null;

    #[ORM\Column]
    private ?float $prix =null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAnimal(): ?string
    {
        return $this->nomAnimal;
    }

    public function setNomAnimal(string $nomAnimal): static
    {
        $this->nomAnimal = $nomAnimal;

        return $this;
    }

    public function getSexeAnimal(): ?string
    {
        return $this->sexeAnimal;
    }

    public function setSexeAnimal(string $sexeAnimal): static
    {
        $this->sexeAnimal = $sexeAnimal;

        return $this;
    }

    public function getAgeAnimal(): ?int
    {
        return $this->ageAnimal;
    }

    public function setAgeAnimal(int $ageAnimal): static
    {
        $this->ageAnimal = $ageAnimal;

        return $this;
    }

    public function getPoidsAnimal(): ?float
    {
        return $this->poidsAnimal;
    }

    public function setPoidsAnimal(float $poidsAnimal): static
    {
        $this->poidsAnimal = $poidsAnimal;

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
