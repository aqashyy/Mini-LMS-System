<?php

namespace App\DTOs\Auth;

readonly class LoginDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $email,
        public string $password
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data["email"],
            password: $data["password"]
        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
