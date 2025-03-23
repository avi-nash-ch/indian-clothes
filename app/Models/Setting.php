<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_us',
        'terms_and_condition',
        'refund',
        'cancellation',
        'privacy_policy',
        'delivery_note',
        'address',
        'amount',
        'delivery_charge',
        'location_range',
        'start_time',
        'end_time',
    ];
}