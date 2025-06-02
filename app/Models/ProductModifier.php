<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModifier extends Model
{
    protected $fillable = [
        'product_id',
        'mod_id',
        'mod_price'
    ];

    public $incrementing = false;
    public function modifier()
    {
        return $this->belongsTo(Modifier::class, 'mod_id', 'mod_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
