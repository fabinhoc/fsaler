<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, 'login']);
Route::get("/logout", [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('/categories', CategoryController::class)->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class)->middleware('auth:sanctum')->except(['show', 'update', 'destroy']);
Route::get('products/{uuid}', [ProductController::class,'show'])->middleware('auth:sanctum');
Route::put('products/{uuid}', [ProductController::class,'update'])->middleware('auth:sanctum');
Route::delete('products/{uuid}', [ProductController::class,'destroy'])->middleware('auth:sanctum');

Route::apiResource('clients', ClientController::class)->middleware('auth:sanctum')->except(['show', 'update', 'destroy']);
Route::get('clients/{uuid}', [ClientController::class,'show'])->middleware('auth:sanctum');
Route::put('clients/{uuid}', [ClientController::class,'update'])->middleware('auth:sanctum');
Route::delete('clients/{uuid}', [ClientController::class,'destroy'])->middleware('auth:sanctum');
