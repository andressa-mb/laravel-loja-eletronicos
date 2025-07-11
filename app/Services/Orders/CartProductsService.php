<?php

namespace App\Services\Orders;

use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartProductsService{

    public function updateCart(array $quantities): array{
        $newList = [];
        foreach(session()->get('cart_list') as $cartItem){
            $productId = $cartItem['product_id'];
            $productModel = Product::find($productId);

            if(isset($quantities[$productId])){
                $newQty = (int)$quantities[$productId];
                $cartItem['quantity'] = $newQty;
                if($cartItem['hasDiscount']){
                    $productModel->discount_data;
                    if($productModel->discount_data->type == "%"){
                        $priceWithDiscount = $cartItem['price'] - ( $cartItem['price'] * ($productModel->discount_data->discount_value / 100) );
                    } else if($productModel->discount_data->type == "R$"){
                        $priceWithDiscount = $cartItem['price'] - $productModel->discount_data->discount_value;
                    }

                    $cartItem['total'] = $priceWithDiscount * $newQty;
                } else {
                    $cartItem['total'] = $cartItem['price'] * $newQty;
                }
            }
            $newList[] = $cartItem;
            session(['updated_cart_list' => $newList]);
        }
        session()->forget('cart_list');
        return $newList;
    }

    public function addProducts(array $productIdsInCart): bool {
        $allCart = session()->get('updated_cart_list', []);
        if($productIdsInCart && is_array($allCart)){
            foreach($productIdsInCart as $productId){
                foreach($allCart as $cart){
                    if(is_array($cart) && isset($cart['product_id']) && $cart['product_id'] == $productId){
                        $orderList = session()->get('order', []);
                        array_push($orderList, ['product_id' => $cart['product_id'], 'name' => $cart['name'], 'quantity' => $cart['quantity'], 'price' => $cart['price'], 'hasDiscount' => $cart['hasDiscount'], 'total' => $cart['total']]);
                        session(['order' => $orderList]);
                    }
                }
            }
            return true;
        }else {
            return false;
        }
    }

    public function updateSessions(): void{
        $prodsUpdates = collect(session()->get('updated_cart_list', []));
        $selectedOrder = collect(session()->get('order', []));

        $rejected = $prodsUpdates->reject(function ($item) use ($selectedOrder) {
            return $selectedOrder->contains('product_id', $item['product_id']);
        });

        session()->put('cart_list', $rejected->values()->toArray());
        session()->forget('updated_cart_list');
    }

}
