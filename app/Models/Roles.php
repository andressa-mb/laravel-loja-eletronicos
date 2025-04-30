<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    const admin = 'admin';
    const buyer = 'buyer';
    protected $table = 'roles';
    protected $fillable = [
        'name'
    ];

    public function users(): HasMany{
        return $this->hasMany(User::class, 'user_roles');
    }

    public function scopeAdminRole(Builder $builder): Builder{
        return $builder->where('name', static::admin);
    }

    public function getTitleAttribute() {
        return $this->attributes['name'];
    }

    public function scopeBuyer(Builder $builder): Builder{
        return $builder->where('name', static::buyer);
    }
}
