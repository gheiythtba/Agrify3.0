<?php

namespace App\Entity;

use App\Repository\AnimalStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;




#[ORM\Entity(repositoryClass: AnimalStockRepository::class)]
/**
 * @Vich\Uploadable
 */
class AnimalStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message :"Le nom de l'animal ne peut pas être vide.")]
    private ?string $nomAnimal = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message :"Le sexe de l'animal ne peut pas être vide.")]
    private ?string $sexeAnimal = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'âge de l'animal ne peut pas être vide.")]
    #[Assert\Range(min: 0, max: 100, notInRangeMessage: "L'âge doit être compris entre {{ min }} et {{ max }} ans.")]
    private ?int $ageAnimal = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le poids de l'animal ne peut pas être vide.")]
    #[Assert\Range(min: 0.1, max: 1000, notInRangeMessage: "Le poids doit être compris entre {{ min }} et {{ max }} kg.")]
    private ?float $poidsAnimal = null;

    #[ORM\Column(length: 255)]
    private ?string $health = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntreeStock = null;

    #[ORM\ManyToOne(inversedBy: 'animalStock')]
    private ?Vente $vente = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide.")]
    #[Assert\Range(min: 0.01, notInRangeMessage: "Le prix doit être supérieur à {{ min }}.")]
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
    
    /**
     * @Vich\UploadableField(mapping="animal_image", fileNameProperty="image")
     */
    private ?File $imageFile = null;

/**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updatedAt = null;
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            // Il est nécessaire que le champ soit modifié pour déclencher l'upload
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
}
