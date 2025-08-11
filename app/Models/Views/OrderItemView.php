<?php

namespace App\Models\Views;

use App\Models\OrderProductItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItemView extends Model
{
    protected $table = 'order_item_view';

    public $casts = [
       'order_date' => 'datetime'
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

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'order_product_items');
    }

}
