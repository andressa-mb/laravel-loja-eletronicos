<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProductItem extends Model
{
    protected $table = 'order_product_items';
    protected $fillable = [
        'order_id', 'product_id', 'order_quantity', 'order_price', 'order_discount', 'order_total'
    ];

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
