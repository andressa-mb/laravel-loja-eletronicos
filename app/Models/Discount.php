<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = [
        'discount_value', 'type', 'start_date', 'end_date', 'message',
    ];

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'discounts_products');
    }
}
