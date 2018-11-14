<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->timestamps();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('departure_time_id');
            $table->foreign('departure_time_id')->references('id')->on('departure_times');
        });
        
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('destinations');
        });
        

        Schema::table('seats', function (Blueprint $table) {
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
        Schema::dropIfExists('tickets');
    }
}
