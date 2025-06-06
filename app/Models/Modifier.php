<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    protected $primaryKey = 'mod_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'mod_id',
        'mod_name',
        'category_id',
        'store_id',
        'mod_image',
        'is_available',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($modifier) {
            if (empty($modifier->mod_id)) {
                $modifier->mod_id = self::generateCustomProductId($modifier);
            }
        });
    }

    protected static function generateCustomProductId($modifier)
    {
        // Fetch category name
        $category = \App\Models\ProductCategory::find($modifier->category_id);
        if (!$category) {
            throw new \Exception('Category not found');
        }

        $prefix = strtoupper(
            substr($category->category_name, 0, 1) .
            substr($modifier->mod_name, 0, 2)
        );

        // Count existing products with this prefix to determine next number
        $existingCount = self::where('mod_id', 'like', $prefix . '%')->count();
        $number = str_pad($existingCount + 1, 3, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_modifiers', 'mod_id', 'product_id')
            ->withPivot('mod_price')
            ->withTimestamps();
    }
    public function Categories()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }
    public function productOrderModifiers()
    {
        return $this->hasMany(ProductOrderModifier::class, 'mod_id', 'mod_id');
    }
}
