<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\Hash;

class Customer extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes;

    // protected $appends = ['document_one', 'document_two']; 

    protected $fillable = [
        'name',
        'email',
        'address',
        'password',
        'mobile',
    ];
}
