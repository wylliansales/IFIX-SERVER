<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendantDepartmentRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendant_department_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendant_id')->unsigned();
            $table->foreign('attendant_id')->references('id')->on('attendants');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests');
            $table->softDeletes();
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
        Schema::dropIfExists('attendant_department_request');
    }
}
