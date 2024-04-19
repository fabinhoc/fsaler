<?php

namespace App\Models;

use App\Enums\OrderDiscountTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'discount_type',
        'discount'
    ];

    protected $casts = [
        'discount_type' => OrderDiscountTypeEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
