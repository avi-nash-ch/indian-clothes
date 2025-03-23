<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_code',
        'offer',
        'maximum_user',
        'minimum_amount',
        'start_date',
        'end_date',
    ];
}
