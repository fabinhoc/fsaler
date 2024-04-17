<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $fillable = [
        'category_id',
        'uuid',
        'name',
        'ean',
        'cost_price',
        'price',
        'purchase_date',
        'description'
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
}
