<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'client' => new ClientResource($this->whenLoaded('client')),
            'payment_type_id' => $this->payment_type_id,
            'payment_date' => $this->payment_date,
            'total' => $this->total,
            'order_discount' => $this->orderDiscount,
            'products' => $this->orderProducts,
            'total_paid' => $this->total_paid,
            'is_paid' => $this->is_paid,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
