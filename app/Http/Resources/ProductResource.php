<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'ean' => $this->ean,
            'cost_price' => $this->cost_price,
            'price' => $this->price,
            'purchase_date' => $this->purchase_date,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'inventory' => new InventoryResource($this->whenLoaded('inventory')),
            'image' => $this->productImage->image_path,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
