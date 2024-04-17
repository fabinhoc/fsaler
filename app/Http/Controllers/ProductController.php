<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success(
            'Resource successfully found',
            Product::with('inventory')->with('category')->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return ApiResponse::success('Resource successfully saved', $this->service->create($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return ApiResponse::success(
            'Resource successfully found',
            Product::where('uuid' , $uuid)->with('inventory')->with('category')->firstOrFail()
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $uuid)
    {
        $response = $this->service->update($request, $uuid);
        return ApiResponse::success(
            'Resource successfully updated',
            $response
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        if (!Product::where('uuid', $uuid)->delete()) {
            return ApiResponse::error('Resource not found', 404);
        }

        return ApiResponse::success('Resource successfully removed', []);
    }
}
