<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipment_id')->unsigned();
            $table->foreign('equipment_id')->references('id')->on('equipments');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests');
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
        Schema::dropIfExists('equipment_request');
    }
}
