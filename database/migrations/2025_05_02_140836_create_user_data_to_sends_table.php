<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataToSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_to_sends', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 150);
            $table->string('email', 100);
            $table->string('zipcode', 10);
            $table->string('city', 50);
            $table->string('state', 2);
            $table->string('street', 70);
            $table->integer('number');
            $table->string('additional', 20);
            $table->string('district', 50);
            $table->string('payment', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data_to_sends');
    }
}
