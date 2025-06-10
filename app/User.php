<?php

namespace App;

use App\Models\Order;
use App\Models\Roles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(): BelongsToMany{
        return $this->belongsToMany(Roles::class, 'user_roles', 'user_id', 'role_id');
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function isAdmin(): bool{
        return $this->roles()->where('name', 'admin')->exists();
    }
}
