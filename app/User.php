<?php

namespace App;

use App\Models\Order;
use App\Models\Role;
use App\Models\Wish;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function isAdmin(): bool{
        return $this->roles()->where('name', 'admin')->exists();
    }

    public function isBuyer(): bool{
        return $this->roles()->where('name', 'buyer')->exists();
    }

    public function wishes(): HasMany{
        return $this->hasMany(Wish::class, 'user_id', 'id');
    }
}
