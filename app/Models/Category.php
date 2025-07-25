<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name', 'slug'
    ];

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class ,'categories_products');
    }
}
