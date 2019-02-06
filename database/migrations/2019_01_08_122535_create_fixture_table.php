<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixtureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixture', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->text('description');
            $table->string('type');
            $table->integer('quantity');
            $table->integer('working')->nullable();
            $table->integer('not_working')->nullable();
            $table->integer('for_repair')->nullable();
            $table->date('date_purchased')->nullable();
            $table->integer('price')->nullable();
            $table->date('date_installed')->nullable();
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
        Schema::dropIfExists('fixture');
    }
}
