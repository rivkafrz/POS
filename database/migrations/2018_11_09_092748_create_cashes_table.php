<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->integer('change');
            $table->timestamps();
        });

         Schema::table('cashes', function (Blueprint $table) {
            $table->unsignedInteger('ticket_id');
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    

    public function down()
    {
        Schema::dropIfExists('cashes');
    }
}
