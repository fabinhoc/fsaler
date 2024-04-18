<?php

namespace App\Enums;

enum OrderStatusEnum:string
{
    case AWAITING_CONFIRMATION = 'awaiting_confirmation';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case PAID = 'paid';
}
