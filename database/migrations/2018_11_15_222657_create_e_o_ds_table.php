<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEODsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_o_d_s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('assign_location_id');
            $table->unsignedInteger('work_time_id');
            $table->boolean('approved')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assign_location_id')->references('id')->on('assign_locations');
            $table->foreign('work_time_id')->references('id')->on('work_times');
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
        Schema::dropIfExists('e_o_d_s');
    }
}
