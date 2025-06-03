<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'product_id',
        'product_name',
        'product_image',
        'store_id',
        'category_id',
        'product_price',
        'is_available',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_id)) {
                $product->product_id = self::generateCustomProductId($product);
            }
        });
    }

    protected static function generateCustomProductId($product)
    {
        // Fetch category name
        $category = \App\Models\ProductCategory::find($product->category_id);
        if (!$category) {
            throw new \Exception('Category not found');
        }

        $prefix = strtoupper(
            substr($category->category_name, 0, 1) .
            substr($product->product_name, 0, 2)
        );

        // Count existing products with this prefix to determine next number
        $existingCount = self::where('product_id', 'like', $prefix . '%')->count();
        $number = str_pad($existingCount + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }

    public function Categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_orders', 'product_id', 'order_id')
            ->withPivot('ordered_amount', 'subtotal')
            ->withTimestamps();
    }
    public function modifiers()
{
    return $this->belongsToMany(Modifier::class, 'product_modifiers', 'product_id', 'mod_id')
        ->withPivot('mod_price')
        ->where('is_available', 1);
}
}
