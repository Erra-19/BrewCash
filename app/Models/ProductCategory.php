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
    ];
    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
