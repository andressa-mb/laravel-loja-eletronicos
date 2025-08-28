<?php

namespace App\Models\Views;

use App\Models\OrderProductItem;
use App\Models\Product;
use App\Models\Traits\WithProduct;
use App\Models\Traits\WithUser;
use App\Models\Traits\WithUserData;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItemView extends Model
{
    use WithProduct;
    use WithUser;
    use WithUserData;
    protected $table = 'order_item_view';

    public $casts = [
       'order_date' => 'datetime'
    ];

    public function orderItems(): HasMany{
        return $this->hasMany(OrderProductItem::class, 'order_id', 'id');
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'order_product_items');
    }

}
