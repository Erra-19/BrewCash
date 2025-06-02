<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $primaryKey = 'store_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'store_id',
        'user_id',
        'store_name',
        'store_address',
        'store_icon',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function staffs()
    {
        return $this->belongsToMany(User::class, 'user_stores', 'store_id', 'user_id')
            ->withPivot('store_role', 'status')
            ->withTimestamps();
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'store_id', 'store_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->store_id)) {
                $store->store_id = self::generateStoreId();
            }
        });
    }

    protected static function generateStoreId()
    {
        $prefix = 'ST';

        $lastStore = self::where('store_id', 'like', "{$prefix}%")
            ->orderBy('store_id', 'desc')
            ->first();

        $number = $lastStore ? intval(substr($lastStore->store_id, 2)) + 1 : 1;

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
