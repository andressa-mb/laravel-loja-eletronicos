<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'quantity', 'hasDiscount', 'total', 'image',
    ];

    public function getRouteKeyName(): string{
        return 'slug';
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    public function configImage(Product $product, string $path, UploadedFile $file): string{
        try{
            /**
             * @var Storage
             */
            $disk = Storage::disk('public');
            return $disk->putFileAs($path, $file, $file->getClientOriginalName());

        }catch(Throwable $e){
            throw $e;
        }
    }

    public function categoriesIds(): array{
        $categoriesIds = [];
        foreach($this->categories()->get(['categories.id']) as $category){
            $categoriesIds[] = $category->pivot->category_id;
        }
        return $categoriesIds;
    }

    public function scopeSortBy(Builder $builder, $valueToSort): Builder{
        if($valueToSort == 'lowest_price'){
            return $builder->oldest('total');
        } else if($valueToSort == 'highest_price'){
            return $builder->latest('total');
        } else if($valueToSort == 'recent'){
            return $builder->latest();
        } else {
            return $builder;
        }
    }

    public function scopeSearchProduct(Builder $builder, $searchProduct): Builder{
        return $builder->where('name', 'ILIKE', "%$searchProduct%");
    }

    public function orderItems(): HasMany{
        return $this->hasMany(OrderProductItem::class, 'product_id', 'id');
    }

    public function wishes(): HasMany{
        return $this->hasMany(Wish::class, 'product_id', 'id');
    }

    public function discounts(): BelongsToMany{
        return $this->belongsToMany(Discount::class, 'discounts_products');
    }

    public function getOriginalTotalAttribute() {
       return $this->price * $this->quantity;
    }

    public function getTotalWithDiscountAttribute(){
        $originalTotal = $this->original_total;
        if(!$this->hasDiscount) return $originalTotal;
        $discount = $this->discounts->first();

        if(!$discount || !$this->isDiscountActive()) return $originalTotal;

        if($discount->type == "%"){
            $valuePercent = $originalTotal * ($discount->discount_value / 100);
            return $originalTotal - $valuePercent;
        }else if($discount->type == "R$"){
            return $originalTotal - $discount->discount_value;
        }

        return 0;
    }

    public function isDiscountActive(): bool{
        $discount = $this->discounts->first();
        if(!$discount) return false;
        $now = now();
        return $now->between(
            Carbon::parse($discount->start_date),
            Carbon::parse($discount->end_date)
        );
    }

    public function scopeWithoutCategory(Builder $builder){
        return $builder->whereDoesntHave('categories')->get();
    }
}
