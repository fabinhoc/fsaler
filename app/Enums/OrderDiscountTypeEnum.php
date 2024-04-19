<?php

namespace App\Enums;

enum OrderDiscountTypeEnum:string
{
    case AMOUNT = 'amount';
    case PERCENTAGE = 'percentage';
}
