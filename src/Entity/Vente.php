<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $quantiteV = null;
    #[ORM\Column]
    private ?float $prixTotal = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateVente = null;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: AnimalStock::class)]
    private Collection $animalStock;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: PlanteStock::class)]
    private Collection $planteStock;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: StockDivers::class)]
    private Collection $stockDivers;

    

    public function __construct()
    {
        $this->animalStock = new ArrayCollection();
        $this->planteStock = new ArrayCollection();
        $this->stockDivers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;
        return $this;
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
     * @return Collection<int, AnimalStock>
     */
    public function getAnimalStock(): Collection
    {
        return $this->animalStock;
    }

    public function addAnimalStock(AnimalStock $animalStock): static
    {
        if (!$this->animalStock->contains($animalStock)) {
            $this->animalStock->add($animalStock);
            $animalStock->setVente($this);
        }

        return $this;
    }

    public function removeAnimalStock(AnimalStock $animalStock): static
    {
        if ($this->animalStock->removeElement($animalStock)) {
            // set the owning side to null (unless already changed)
            if ($animalStock->getVente() === $this) {
                $animalStock->setVente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlanteStock>
     */
    public function getPlanteStock(): Collection
    {
        return $this->planteStock;
    }

    public function addPlanteStock(PlanteStock $planteStock): static
    {
        if (!$this->planteStock->contains($planteStock)) {
            $this->planteStock->add($planteStock);
            $planteStock->setVente($this);
        }

        return $this;
    }

    public function removePlanteStock(PlanteStock $planteStock): static
    {
        if ($this->planteStock->removeElement($planteStock)) {
            // set the owning side to null (unless already changed)
            if ($planteStock->getVente() === $this) {
                $planteStock->setVente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockDivers>
     */
    public function getStockDivers(): Collection
    {
        return $this->stockDivers;
    }

    public function addStockDiver(StockDivers $stockDiver): static
    {
        if (!$this->stockDivers->contains($stockDiver)) {
            $this->stockDivers->add($stockDiver);
            $stockDiver->setVente($this);
        }

        return $this;
    }

    public function removeStockDiver(StockDivers $stockDiver): static
    {
        if ($this->stockDivers->removeElement($stockDiver)) {
            // set the owning side to null (unless already changed)
            if ($stockDiver->getVente() === $this) {
                $stockDiver->setVente(null);
            }
        }

        return $this;
    }

    public function getQuantiteV(): ?float
    {
        return $this->quantiteV;
    }

    public function setQuantiteV(float $quantiteV): static
    {
        $this->quantiteV = $quantiteV;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->dateVente;
    }

    public function setDateVente(\DateTimeInterface $dateVente): static
    {
        $this->dateVente = $dateVente;

        return $this;
    }

}
