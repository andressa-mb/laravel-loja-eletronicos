<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $table = 'tracks';
    protected $fillable = [
        'order_id', 'shipping_status', 'obs', 'estimated_delivery', 'delivered_at'
    ];

    protected $casts = [
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    public function orders(): HasMany {
        return $this->hasMany(Order::class, 'order_id', 'id');
    }
}
