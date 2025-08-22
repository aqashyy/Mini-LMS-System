<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthServiceInterface $authServiceInterface
    ) {}

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password'  => 'required'
        ]);

        $token = $this->authServiceInterface->login(LoginDTO::fromArray($request->only('email','password')));

        if( $token ) {
            return response()->json([
                'message'   => 'Login success',
                'token'     => $token,
            ],200);
        }
        
        return response()->json([
            'message' => 'invalid credentials!'
        ],401);
    }
}
