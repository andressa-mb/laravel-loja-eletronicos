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

    public function newOrder(UserDataToSend $userDataId, Product $product, array $prod): Order{
        $qtdConvertion = is_array($prod['quantity'])
            ? str_replace("Quantidade: ", "", $prod['quantity'][0] ?? '1')
            : str_replace("Quantidade: ", "", $prod['quantity']);

        $price = is_array($prod['price'])
            ? floatval(str_replace(['Preço: ', '.', ','], ['', '', '.'], $prod['price'][0] ?? '0'))
            : floatval(str_replace(['Preço: ', '.', ','], ['', '', '.'], $prod['price']));

        $totalNumerico = str_replace(['.', ','], ['', '.'], $prod['total']);
        $totalNumerico = (float)preg_replace('/[^0-9.]/', '', $totalNumerico);

        $discountType = null;
        $discountValue = null;

        if ($product->hasDiscount) {
            $discountType = $product->discount_data->type;
            $discountValue = $product->discount_data->discount_value;
        }

        $newOrder = Order::create([
            'status' => Order::pendente,
            'user_id' => auth()->id(),
            'user_data_id' => $userDataId->id
        ]);

        $newQtd = $product->quantity <= $qtdConvertion ? 0 : $product->quantity - $qtdConvertion;
        $product->update(['quantity' => $newQtd]);

        OrderProductItem::create([
            'order_id' => $newOrder->id,
            'product_id' => is_array($prod['id']) ? $prod['id'][0] : $prod['id'],
            'order_quantity' => (int)$qtdConvertion,
            'order_price' => $price,
            'order_discount_type' => $discountType,
            'order_discount_value' => $discountValue,
            'order_total' => $totalNumerico
        ]);

        return $newOrder;
    }
}
