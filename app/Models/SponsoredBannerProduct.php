<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsoredBannerProduct extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'banner_id',
        'product_id',
    ];
}
