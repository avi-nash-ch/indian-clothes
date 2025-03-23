<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionalBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
    ];
    
    public function products()
    {
        return $this->hasMany(PromotionalBannerProduct::class, 'banner_id');
    }

}
