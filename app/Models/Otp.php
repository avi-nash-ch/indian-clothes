<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Otp extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'mobile',
        'otp'
    ];
}
