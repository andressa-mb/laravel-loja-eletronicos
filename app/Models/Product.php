<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
}
