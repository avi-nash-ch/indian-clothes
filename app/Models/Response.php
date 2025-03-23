<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_response',
    ];

    protected $casts = [
        'full_response' => 'array', // Ensure it's stored as JSON
    ];
}

