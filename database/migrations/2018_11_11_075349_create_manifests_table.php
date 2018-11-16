<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver',30);
            $table->string('no_body',8);
            $table->string('note');
            $table->timestamps();
        });

        Schema::table('manifests', function (Blueprint $table) {
            $table->unsignedInteger('departure_time_id');
            $table->foreign('departure_time_id')->references('id')->on('departure_times');
        });

         Schema::table('manifests', function (Blueprint $table) {
            $table->unsignedInteger('assign_location_id');
            $table->foreign('assign_location_id')->references('id')->on('assign_locations');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manifests');
    }
}
