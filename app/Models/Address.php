<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'house_address',
        'street_address',
        'locality',
        'landmark',
        'pincode',
        'lat',
        'long',
    ];
}
