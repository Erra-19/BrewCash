<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'name',
        'phone_number',
        'role',
        'picture',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function stores()
    {
        return $this->hasMany(Store::class, 'user_id', 'user_id');
    }
    public function staffs()
    {
        return $this->belongsToMany(Store::class, 'user_stores', 'user_id', 'store_id')
            ->withPivot('store_role', 'status')
            ->withTimestamps();
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id', 'user_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->user_id) && !empty($user->role)) {
                $user->user_id = self::generateUserId($user->role);
            }
        });
    }

    protected static function generateUserId($role)
    {
        $role = ucfirst(strtolower($role));
        $prefix = '';
        switch ($role) {
            case 'Owner':
                $prefix = 'OW';
                break;
            case 'Staff':
                $prefix = 'ST';
                break;
            default:
                throw new \InvalidArgumentException("Invalid Role: $role");
        }

        $lastUser = self::where('role', $role)
            ->where('user_id', 'like', "{$prefix}%")
            ->orderBy('user_id', 'desc')
            ->first();

        $number = $lastUser ? intval(substr($lastUser->user_id, 2)) + 1 : 1;

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    public function isOwner()
    {
        return $this->role === 'Owner';
    }

    public function isStaff()
    {
        return $this->role === 'Staff';
    }
}
