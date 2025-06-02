<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
public $incrementing = false;
protected $keyType = 'string';
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'paid_amount',
        'change',
        'payment_method',
        'paid_at',
        'cancelled_at',
        'total_price',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_orders', 'order_id', 'product_id')
            ->withPivot('ordered_amount', 'subtotal')
            ->withTimestamps();
    }
    public function user() { 
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'order_id', 'order_id');
    }
    public function productOrders()
{
    return $this->hasMany(ProductOrder::class, 'order_id', 'order_id');
}
}
