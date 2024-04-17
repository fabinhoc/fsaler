<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'payment_type_id',
        'payment_date',
        'is_paid',
        'total',
        'total_paid',
        'description',
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
