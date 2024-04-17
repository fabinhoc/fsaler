<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(StoreProductRequest $request)
    {
        $product = new Product($request->validated());
        $product->save();
        $product->inventory()->save(
           new Inventory($request->only('quantity'))
        );
        $product->load('inventory');

        return $product;
    }

    public function update(UpdateProductRequest $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->with('inventory')->first();
        $product->update($request->validated());
        $product->inventory->update($request->only('quantity'));
        $product->save();

        return $product;
    }
}
