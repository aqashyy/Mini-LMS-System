<?php

namespace App\Services\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function login(LoginDTO $loginDTO): ?string
    {
        if( !Auth::attempt($loginDTO->toArray()) ) {
            return null;
        }
        $token = auth()->user()->createToken('api-auth-token')->plainTextToken;
        return $token;
    }
}
