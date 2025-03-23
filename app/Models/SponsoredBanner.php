<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsoredBanner extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'image',
    ];

    public function products()
    {
        return $this->hasMany(SponsoredBannerProduct::class, 'banner_id');
    }

}
