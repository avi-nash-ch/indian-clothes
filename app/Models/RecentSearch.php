<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecentSearch extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'customer_id',
        'search_term'
    ];
}
