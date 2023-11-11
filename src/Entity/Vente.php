<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: AnimalStock::class)]
    private Collection $animalStock;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: PlanteStock::class)]
    private Collection $planteStock;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: StockDivers::class)]
    private Collection $stockDivers;

    #[ORM\Column]
    private ?float $prix = null;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
