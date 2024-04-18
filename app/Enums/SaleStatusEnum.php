<?php

namespace App\Enums;

enum SaleStatusEnum:string
{
    case AWAITING_CONFIRMATION = 'awaiting_confirmation';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
}
