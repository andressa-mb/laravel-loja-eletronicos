<?php

namespace App\Services\Product;

use App\Events\ProductsUpdated;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductService {
    public function storeProduct(array $validation, ?int $discountId = null): Product{
        $productToCreate = [
            'name' => $validation['name'],
            'slug' => Str::slug($validation['name']),
            'description' => $validation['description'],
            'price' => $validation['price'],
            'quantity' => $validation['quantity'],
            'hasDiscount' => $validation['hasDiscount'],
            'total' => $validation['price'],
            'image' => $validation['image'] ?? null
        ];

        //OBS: TIREI O ID DO CAMINHO POIS AINDA NÃO EXISTIA, PENSAR EM QUAL CAMINHO POSSO DEIXAR DEPOIS DISSO
        $product = new Product();
        if(isset($validation['image'])){
            $productToCreate['image'] = $product->configImage($product, "product_images", $validation['image']);
        }

        $createdProduct = $product->create($productToCreate);

        /* ASSOCIAR AO DESCONTO */
       if($validation['hasDiscount'] == 1){
            $createdProduct->discounts()->attach($discountId);
            event(new ProductsUpdated($createdProduct, true));
        }

        return $createdProduct;
    }

    public function updateProduct(Product $product, array $validation, ?int $discountId = null) : Product{
        $productToUpdate = [
            'name' => $validation['name'],
            'slug' => Str::slug($validation['name']),
            'description' => $validation['description'],
            'price' => $validation['price'],
            'quantity' => $validation['quantity'],
            'hasDiscount' => $validation['hasDiscount'],
            'total' => $validation['price'],
            'image' => $validation['image'] ?? null,
        ];

        if(isset($validation['image'])){
            $productToUpdate['image'] = $product->configImage($product, "product_images", $validation['image']);
        }

        $product->update($productToUpdate);

        /* ASSOCIAR AO DESCONTO */
        if(intval($validation['hasDiscount']) == 1){
            $product->discounts()->sync([$discountId]);
            event(new ProductsUpdated($product, false));
        }else {
            $product->discounts()->detach();
        }

        return $product;
    }
}
