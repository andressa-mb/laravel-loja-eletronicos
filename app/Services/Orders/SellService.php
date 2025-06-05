<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderProductItem;
use App\Models\Product;
use App\Models\UserDataToSend;

class SellService {

    public static function new(): self {
        return app()->make(static::class);
    }

    public function newOrder(UserDataToSend $userDataId, Product $product, array $prod): void{
        $newOrder = Order::create([
            'status' => Order::pendente,
            'user_id' => auth()->id(),
            'user_data_id' => $userDataId->id
        ]);
        $qtdConvertion = str_replace("Quantidade: ", "", $prod['quantity']);
        $newQtd = $product->quantity <= $qtdConvertion ? 0 : $product->quantity - $qtdConvertion;
        $product->update([
            'quantity' => $newQtd
        ]);
        OrderProductItem::create([
            'order_id' => $newOrder->id,
            'product_id' => $prod['id'],
            'order_quantity' => $qtdConvertion,
            'order_price' => floatval(str_replace("Preço: ", "", $prod['price'])),
            'order_discount' => floatval(str_replace("Desconto: ", "", $prod['discount'])),
            'order_total' => floatval(str_replace("Total: ", "", $prod['total']))
        ]);
    }
}
