<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    use HasFactory;

    protected $table = 'delivery_boy_management';

    protected $fillable = [
        'name',
        'mobile',
        'password',
        'simple_password',
        'token',
        'fcm',
        'status',
        'address',
        'adhar_no',
        'license_no',
        'pan_no',
        'image',
        'delivery_amount',
        'vehicle_no',
        'vehicle_desc',
        'delivery_charge'
    ];
}
