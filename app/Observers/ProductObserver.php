<?php

namespace App\Observers;

use App\Events\ProductsUpdated;
use App\Models\Product;
use App\Models\Wish;
use App\Notifications\ProductChangeNotification;

class ProductObserver
{
    public function getChangeFields(Product $product){
        $changes = [];
        $original = $product->getOriginal();

        if($product->wasChanged('price')){
            $changes[] = "Preço alterado de {$original['price']} para {$product->price}";
        }
        if($product->wasChanged('quantity')){
            if($product->quantity > $original['quantity']){
                $changes[] = "Aumentou o estoque! Quantidade atual: $product->quantity";
            }else {
                $changes[] = "Diminuiu o estoque! Quantidade atual: $product->quantity";
            }
        }
        if($product->wasChanged('hasDiscount')){
            $valueDiscount = '0 - SEM DESCONTO';
            if(!is_null($product->discount_data)){
                if($product->discount_data->type == '%'){
                    $valueDiscount = "{$product->discount_data->discount_value}%";
                } else {
                    $valueDiscount = "R$ {$product->discount_data->discount_value}";
                }
            }
            $changes[] = "Desconto alterado para {$valueDiscount}";
        }
        return $changes;
    }

    public function getQuantityChange(Product $product){
        $original = $product->getOriginal('quantity');

        if($product->wasChanged('quantity') && $product->quantity != $original){
            return $product;
        }
    }

    /**
     * Handle the product "created" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the product "updated" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        if($this->getChangeFields($product)){
            $hasWishes = Wish::whereHas('products', function($query) use ($product){
                $query->where('product_id', $product->id);
            })->get();

            //usuarios que tenham esse produto na lista de desejo
            //para notificar eles

            foreach($hasWishes as $wish){
                $user = $wish->user;
                $user->notify(new ProductChangeNotification($product, $wish));
            }
        }

        if($this->getQuantityChange($product)){
            event(new ProductsUpdated($product, false));
        }

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
