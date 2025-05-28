<?php

namespace App\Models;

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
        'name', 'slug', 'description', 'price', 'quantity', 'discount', 'total', 'image',
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
}
