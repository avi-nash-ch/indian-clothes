<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $appends = ["invoice_full_path"];

    protected $fillable = [
        'customer_id',
        'order_id',
        'product_name',
        'quantity',
        'discount',
        'amount',
        'address_id',
        'payment_type',
        'delivery_charge',
        'deliveryboy_id',
        'address_id',
        'status',
        'delivery_boy_id',
        'coupon_code',
        'total_amount',
        'house_address',
        'street_address',
        'locality',
        'landmark',
        'pincode',
        'lat',
        'long',
        'reason',
        'refund_reason',
        'invoice_path',
        'comment',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryBoy()
    {
        return $this->belongsTo(DeliveryBoy::class);
    }
   
    public function orderMappedproduct()
    {
        return $this->hasMany(OrderMappedProduct::class); 
    }
    public function mappedProducts()
    {
        return $this->hasMany(OrderMappedProduct::class, 'order_id', 'id');
    }

    public function getInvoiceFullPathAttribute() {
        if($this->invoice_path)
        return asset('storage/' . $this->invoice_path);
    else
    return "";
    }
}