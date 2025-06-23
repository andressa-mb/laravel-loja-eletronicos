<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = [
        'product_id', 'discount_value', 'type', 'start_date', 'end_date', 'message',
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
