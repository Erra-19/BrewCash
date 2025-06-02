<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderModifier extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'line_id',
        'mod_id',
        'quantity',
        'price_at_time',
    ];

    public function productOrder()
    {
        return $this->belongsTo(ProductOrder::class, 'line_id', 'line_id');
    }

    public function modifier()
    {
        return $this->belongsTo(Modifier::class, 'mod_id', 'mod_id');
    }
}