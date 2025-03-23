<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionalBannerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_id',
        'product_id',
    ];

}
