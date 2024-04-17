<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function login(LoginRequest $request): array
    {
        $payload = $request->only('email', 'password');

        if (Auth::attempt($payload)) {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('user-token')->plainTextToken;

            return [
                'token' => $token,
                'user' => $user
            ];
        }

        throw new AuthenticationException;
    }

    public function logout(Request $request): void
    {
        $request->user()->tokens()->delete();
    }
}
