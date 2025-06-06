<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable =[
        'report_id',
        'user_id',
        'order_id',
        'store_id',
        'action',
        'type',
        'meta',
    ];
    protected $casts = [
        'meta' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }
    protected static function booted()
    {
        static::created(function ($log) {
            $date = now()->format('Ymd-H');
            $user = $log->user_id;
            $order = $log->order_id ?? '0000';
            $store = $log->store_id ?? '0000';

            $reportId = sprintf('L%04d-%s-%s-%s-%s', 
                $log->id, $date, $user, $order, $store
            );
            \DB::table('logs')->where('id', $log->id)->update(['report_id' => $reportId]);
        });
    }
}
