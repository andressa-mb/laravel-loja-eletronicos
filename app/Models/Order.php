<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const pendente = 'Pendente';
    const confirmado = 'Confirmado';
    const cancelado = 'Cancelado';
    protected $table = 'orders';
    protected $fillable = [
        'status', 'user_id', 'user_data_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userData(): BelongsTo{
        return $this->belongsTo(UserDataToSend::class, 'user_data_id', 'id');
    }

    public function orderItems(): HasMany{
        return $this->hasMany(OrderProductItem::class, 'order_id', 'id');
    }

}
