<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Traits\WithOrder;
use App\Models\Traits\WithProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProductItem extends Model
{
    use WithProduct;
    use WithOrder;
    protected $table = 'order_product_items';
    protected $fillable = [
        'order_id', 'product_id', 'order_quantity', 'order_price', 'order_discount_type', 'order_discount_value', 'order_total'
    ];

    public $casts = [
       'order_date' => 'datetime'
    ];

}
