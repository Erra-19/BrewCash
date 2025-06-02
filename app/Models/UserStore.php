<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStore extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'store_role',
        'status',
        'start_date',
        'end_date',
    ];
}
