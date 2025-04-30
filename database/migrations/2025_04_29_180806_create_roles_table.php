<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('role_id')
            ->references('id')
            ->on('roles')
            ->onDelete('restrict')
            ->cascadeOnUpdate();
            $table->timestamps();
        });

        $date = now()->format('Y-m-d H:i:s');
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'name' => 'buyer', 'created_at' => $date, 'updated_at' => $date],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles');
    }
}
