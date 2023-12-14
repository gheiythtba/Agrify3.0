<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

enum TodoSeverity: string
{
    case SEVERE = 'Severe';
    case MODERATE = 'Moderate';
    case LOW = 'Low';
}

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?String $todoDescription;

    #[ORM\Column(type: 'string', nullable: false, enumType: TodoSeverity::class)]
    private TodoSeverity $severity;

    #[ORM\ManyToOne(targetEntity:Task::class, inversedBy:"todos",fetch:"EAGER")]
    #[ORM\JoinColumn(name: "parent_task_id", referencedColumnName: "id")]
    private ?task $parentTask;


    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter and Setter for $todoDescription
    public function getTodoDescription(): ?string
    {
        return $this->todoDescription;
    }

    public function setTodoDescription(?string $todoDescription): self
    {
        $this->todoDescription = $todoDescription;

        return $this;
    }

    // Getter and Setter for $severity
    public function getSeverity(): TodoSeverity
    {
        return $this->severity;
    }

    public function setSeverity(TodoSeverity $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    // Getter and Setter for $parentTask
    public function getParentTask(): ?Task
    {
        return $this->parentTask;
    }

    public function setParentTask(?Task $parentTask): self
    {
        $this->parentTask = $parentTask;

        return $this;
    }
}
