<?php

namespace App\Models;

use App\Models\Traits\WithUser;
use App\Models\Traits\WithUserData;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const pendente = 'Pendente';
    const confirmado = 'Confirmado';
    const cancelado = 'Cancelado';

    use WithUserData;
    use WithUser;
    protected $table = 'orders';
    protected $fillable = [
        'status', 'user_id', 'user_data_id'
    ];

    public function getStatusAttribute(){
        return $this->attributes['status'];
    }

    public function orderItems(): HasMany{
        return $this->hasMany(OrderProductItem::class, 'order_id', 'id');
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'order_product_items');
    }

    public function track(): BelongsTo{
        return $this->belongsTo(Track::class, 'id', 'order_id');
    }

}
