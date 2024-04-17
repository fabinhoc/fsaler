<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::with('category')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return (new ProductResource($this->service->create($request)))
            ->additional(['message'=> 'Resource successfully created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return new ProductResource(Product::where('uuid' , $uuid)
            ->with('inventory')
            ->with('category')
            ->firstOrFail()
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $uuid)
    {
        $response = $this->service->update($request, $uuid);
        return (new ProductResource($response))->additional(['message' => 'Resource successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        if (!Product::where('uuid', $uuid)->delete()) {
            throw new NotFoundHttpException;
        }

        return response()->json([], 204);
    }
}
