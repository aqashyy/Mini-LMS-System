<?php

namespace App\Interfaces;

use App\DTOs\Auth\LoginDTO;

interface AuthServiceInterface
{
    public function login(LoginDTO $loginDTO): ?string;
}
