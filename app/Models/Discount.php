<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

    public function getStartDateAttribute($value){
        return $this->attributes['start_date'] = Carbon::parse($value)->format('d-m-Y');
    }

    public function getEndDateAttribute($value){
        return $this->attributes['end_date'] = Carbon::parse($value)->format('d-m-Y');
    }

    public function getStartDateInputAttribute(){
        return $this->start_date ? Carbon::parse($this->start_date)->format('Y-m-d') : null;
    }

    public function getEndDateInputAttribute(){
        return $this->end_date ? Carbon::parse($this->end_date)->format('Y-m-d') : null;
    }
}
