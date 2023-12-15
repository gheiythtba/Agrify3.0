<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


enum TaskStatus: string
{
    case OPEN = 'Open';
    case IN_PROGRESS = 'In_progress';
    case COMPLETED = 'Completed';
    case IN_REVIEW = 'In_review';
    case CANCELED = 'Canceled';
}

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $taskTitle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column(type: 'string', nullable: false, enumType: TaskStatus::class)]
    private ?TaskStatus $status = null;
    
    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"tasks")]
    #[ORM\JoinColumn(name:"assignedChef_id", referencedColumnName:"user_id")]
    private ?User $assignedChef;

    #[ORM\OneToMany(mappedBy: 'parentTask', targetEntity: Todo::class , cascade: ['persist', 'remove'])]
    private Collection $todos;

    public function __construct()
    {
        $this->creationDate = new \DateTime(); 
        $this->todos = new ArrayCollection();
    }

    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskTitle(): ?string
    {
        return $this->taskTitle;
    }

    public function setTaskTitle(string $taskTitle): static
    {
        $this->taskTitle = $taskTitle;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }
    
    public function getAssignedChef(): ?User
    {
        return $this->assignedChef;
    }

    public function setAssignedChef(?User $assignedChef): static
    {
        $this->assignedChef = $assignedChef;
        return $this;
    }

    public function getStatus(): ?TaskStatus
    {
        return $this->status;
    }

    public function setStatus(?TaskStatus $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function addTodo(Todo $todo): self
    {
        $todo->setParentTask($this);
        $this->todos->add($todo);

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->contains($todo)) {
            $this->todos->removeElement($todo);

            // set the owning side to null only if it's associated with this task
            if ($todo->getParentTask() === $this) {
                $todo->setParentTask(null);
            }
        }

        return $this;
    }
    
}
