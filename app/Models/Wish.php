<?php

namespace App\Models;

use App\Models\Traits\WithProduct;
use App\Models\Traits\WithUser;
use Illuminate\Database\Eloquent\Model;
class Wish extends Model
{
    use WithProduct;
    use WithUser;

    protected $table = 'wishes';
    protected $fillable = [
        'user_id', 'product_id'
    ];

}
