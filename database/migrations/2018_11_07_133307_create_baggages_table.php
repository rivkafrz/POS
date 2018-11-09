<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaggagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baggages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount', 3);
            $table->timestamps();
        });

        Schema::table('baggages', function (Blueprint $table) {
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
        Schema::dropIfExists('baggages');
    }
}
