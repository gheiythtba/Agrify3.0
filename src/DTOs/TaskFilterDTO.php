<?php 
namespace App\DTOs;
use App\Entity\TaskStatus;

class TaskFilterDTO
{
    public ?string $searchTitle;
    public ?\DateTimeInterface $createdAfter;
    public ?\DateTimeInterface $dueBefore;

}