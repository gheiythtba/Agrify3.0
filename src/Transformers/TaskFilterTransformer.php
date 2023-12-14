<?php


namespace App\Transformers;

use App\DTOs\TaskFilterDTO;
use Symfony\Component\Form\DataTransformerInterface;

class TaskFilterTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // Transform TaskFilterDTO object to array (if needed)
        return $value;
    }

    public function reverseTransform($value)
    {
        $taskFilterDTO = new TaskFilterDTO();

        $taskFilterDTO->searchTitle = $value['searchTitle'] ?? null;

        // Transform date strings to DateTimeInterface objects
        $taskFilterDTO->createdAfter = isset($value['createdAfter']) ? new \DateTimeImmutable($value['createdAfter']) : null;
        $taskFilterDTO->dueBefore = isset($value['dueBefore']) ? new \DateTimeImmutable($value['dueBefore']) : null;

        return $taskFilterDTO;
    }
}