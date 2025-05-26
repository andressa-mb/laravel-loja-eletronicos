<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status', 10);
            $table->foreignId('user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->foreignId('user_data_id')
            ->references('id')
            ->on('user_data_to_sends')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->timestamps();
        });

        Schema::create('order_product_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
            ->references('id')
            ->on('orders')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('product_id')
            ->references('id')
            ->on('products')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->integer('order_quantity');
            $table->decimal('order_price', 8, 2);
            $table->decimal('order_discount', 8, 2)->nullable();
            $table->decimal('order_total', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_items');
        Schema::dropIfExists('orders');
    }
}
