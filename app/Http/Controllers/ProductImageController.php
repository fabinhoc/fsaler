<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProductImageRequest;
use App\Http\Resources\ProductImageResource;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductImageController extends Controller
{
    public function uploadImage(UploadProductImageRequest $request)
    {
        $productImage = ProductImage::where('product_id', $request->product_id)->first();
        if (!$productImage) {
            $productImage = new ProductImage();
        }

        if ($productImage) {
            Storage::disk('s3')->delete($productImage->image_path);
        }


        $path = $request->file("image")->store('products');
        $productImage->product_id = $request->product_id;
        $productImage->image_path = Storage::path($path);
        $productImage->save();

        return (new ProductImageResource($productImage))
            ->additional(['message'=> 'Resource successfully saved']);;
    }
}
