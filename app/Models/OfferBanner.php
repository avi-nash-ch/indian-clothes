<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferBanner extends Model
{
    use HasFactory;


    protected $table = 'offer_banners';
    protected $fillable = [
        'name',
        'image',
        'start_date',
        'end_date',
    ];

    public function products()
    {
        return $this->hasMany(OfferProduct::class, 'offer_id');
    }


}


