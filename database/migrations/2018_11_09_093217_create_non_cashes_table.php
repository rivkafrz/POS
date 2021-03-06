<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNonCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('card_type');
            // 1 debit
            // 0 credit
            $table->string('no_card',16);
            $table->timestamps();
        });

        Schema::table('non_cashes', function (Blueprint $table) {
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
        Schema::dropIfExists('non_cashes');
    }
}
