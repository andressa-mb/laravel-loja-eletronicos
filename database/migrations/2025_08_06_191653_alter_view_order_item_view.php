<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterViewOrderItemView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS order_item_view");
        $sql = "
           CREATE VIEW order_item_view AS SELECT order_product_items.id,
                order_product_items.order_id,
                order_product_items.product_id,
                order_product_items.order_quantity,
                order_product_items.order_price,
                order_product_items.order_discount_type,
                order_product_items.order_discount_value,
                order_product_items.order_total,
                order_product_items.created_at,
                order_product_items.updated_at,
                products.name AS product_name,
                orders.created_at AS order_date
            FROM order_product_items
                JOIN products ON order_product_items.product_id = products.id
                JOIN orders ON order_product_items.order_id = orders.id
            GROUP BY order_product_items.product_id, order_product_items.id, products.name, orders.created_at
            ORDER BY order_product_items.order_quantity DESC;
        ";
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS order_item_view");
    }
}
