<?php

namespace App\DTOs;

readonly class CourseDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $title,
        public string $description,
        public float $price,

    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data["title"],
            description: $data["description"],
            price: $data["price"],
            );
    }
    
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
