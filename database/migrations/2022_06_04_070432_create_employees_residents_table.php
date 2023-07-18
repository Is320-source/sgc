<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_residents', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('name', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('function', 180)->nullable();
            $table->integer('code')->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('resident_id')->nullable();
            $table->enum('status', ['0', '1', '2'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_residents');
    }
}
