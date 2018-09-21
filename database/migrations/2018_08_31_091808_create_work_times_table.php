<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('work_time');
            $table->timestamps();
        });

        Schema::table('work_times', function (Blueprint $table) {
            $table->unsignedInteger('assign_location_id');
            $table->foreign('assign_location_id')->references('id')->on('assign_locations');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('work_time_id')->nullable();
            $table->foreign('work_time_id')->references('id')->on('work_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_times');
    }
}
