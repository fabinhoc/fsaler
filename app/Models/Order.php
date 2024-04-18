<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'payment_type_id',
        'payment_date',
        'total',
        'discount',
        'total_paid',
        'is_paid',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }
}
