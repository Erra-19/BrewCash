<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'line_id';
    public $incrementing = true;
    protected $fillable = [
        'product_id',
        'order_id',
        'ordered_amount',
        'subtotal',
    ];

    public function modifiers()
    {
        return $this->hasMany(ProductOrderModifier::class, 'line_id', 'line_id');
    }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
}
}