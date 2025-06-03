<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $primaryKey = 'category_id';
    public $timestamps = false;
    protected $fillable = [
        'category_name',
        'category_image',
        'store_id',
    ];
    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
