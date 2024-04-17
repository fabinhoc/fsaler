<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $service)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            $response = $this->service->login($request);
            return ApiResponse::success('Login Successful', [
                'token' => $response['token'],
                'user' => $response['user']]
            );
        } catch (AuthenticationException $exception) {
            return ApiResponse::error($exception->getMessage(), 401);
        }
    }

    public function logout(Request $request)
    {
        $this->service->logout($request);
        return ApiResponse::success('Logout Successful',[], 204);
    }
}
