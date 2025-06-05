<?php

namespace App\Services\Orders;

class CartProductsService{

    public function updateCart(array $quantities): array{
        $newList = [];
        foreach(session()->get('cart_list') as $cartItem){
            $productId = $cartItem['product_id'];
            if(isset($quantities[$productId])){
                $newQty = (int)$quantities[$productId];
                $cartItem['quantity'] = $newQty;
                $cartItem['total'] = ($cartItem['price'] - $cartItem['discount']) * $newQty;
            }
            $newList[] = $cartItem;
            session(['updated_cart_list' => $newList]);
        }
        session()->forget('cart_list');

        return $newList;
    }

    public function addProducts(array $productIdsInCart): bool {
        $allCart = session()->get('updated_cart_list', ['product_id', 'name', 'quantity', 'price', 'discount', 'total']);
        if($productIdsInCart){
            foreach($productIdsInCart as $productId){
                foreach($allCart as $cart){
                    if($cart['product_id'] == $productId){
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
