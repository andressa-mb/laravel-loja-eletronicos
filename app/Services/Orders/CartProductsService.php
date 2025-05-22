<?php

namespace App\Services\Orders;

class CartProductsService{

    public function addProducts(array $productsInCart): bool {
        $allCart = session()->get('cart_list', ['product_id', 'name', 'quantity', 'price', 'discount', 'total']);
        if($productsInCart){
            foreach($productsInCart as $product){
                foreach($allCart as $cart){
                    if($cart['product_id'] == $product){
                        $orderList = session()->get('order', []);
                        array_push($orderList, ['product_id' => $cart['product_id'], 'name' => $cart['name'], 'quantity' => $cart['quantity'], 'price' => $cart['price'], 'discount' => $cart['discount'], 'total' => $cart['total']]);
                        session(['order' => $orderList]);
                    }
                }
            }
            return true;
        }else {
            return false;
        }
    }

    public function atualizarCart(){
        $allCart = collect(session()->get('cart_list'));
        $orderList = collect(session()->get('order'));
        $orderProductIds = $orderList->pluck('product_id');
        $updatedCart = $allCart->whereNotIn('product_id', $orderProductIds)->values();

        return session()->put('cart_list',  $updatedCart->toArray());
    }
}
