<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seat_number');
            $table->timestamps();
        });

         Schema::table('seats', function (Blueprint $table) {
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('seats', function (Blueprint $table) {
             $table->unsignedInteger('departure_time_id');
             $table->foreign('departure_time_id')->references('id')->on('departure_times');
        });

        Schema::table('seats', function (Blueprint $table) {
             $table->unsignedInteger('destination_id');
             $table->foreign('destination_id')->references('id')->on('destinations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}