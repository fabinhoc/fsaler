<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class ApiResponse
{
    public static function success(string $message, array | object $data = [], $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(string $message, int $code, array $data = [])
    {
        return response()->json([
            'success'=> false,
            'message'=> $message,
            'data' => $data], $code
        );
    }
}
