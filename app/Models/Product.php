<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // Delete related records programmatically
            $product->subCategories()->delete();
            $product->carts()->delete();
            $product->orderItems()->delete();
            $product->bestSellers()->delete(); // Delete from best sellers
        });
    }

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'quantity',
        'image',
        'image1',
        'image2',
        'image3',
        'image4',
        'unit_id',
        'weight',
        'trending',
        'tags',
        'discount_price',
        'expiry_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }


    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function bestSellers()
    {
        return $this->hasMany(BestSeller::class, 'product_id');
    }
}
