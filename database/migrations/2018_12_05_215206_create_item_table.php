<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->text('description');
            $table->string('category');
            $table->string('brand');
            $table->integer('quantity');
            $table->string('serial');
            $table->string('date_purchased');
            $table->string('amount');
            $table->string('date_issued');
            $table->integer('working')->nullable();
            $table->integer('not_working')->nullable();
            $table->integer('for_repair')->nullable();
            $table->integer('for_calibrate')->nullable();
            $table->string('remarks');
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
        Schema::dropIfExists('item');
    }
}
